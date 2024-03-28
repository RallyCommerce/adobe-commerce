<?php

namespace Rally\Checkout\Service\Order;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Webapi\Exception;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterfaceFactory;
use Rally\Checkout\Api\ConfigInterface;
use Rally\Checkout\Api\Data\OrderDataInterface;
use Rally\Checkout\Api\Data\OrderDataInterfaceFactory;
use Rally\Checkout\Api\Data\ShippingLinesDataInterfaceFactory;
use Rally\Checkout\Service\CartMapper;
use Rally\Checkout\Api\Data\OrdersListDataInterface;
use Rally\Checkout\Api\Data\OrdersListDataInterfaceFactory;
use Rally\Checkout\Api\Data\ListOrderDataInterfaceFactory;
use Rally\Checkout\Api\Data\ListOrderProductDataInterfaceFactory;

class DataManager
{
    public function __construct(
        protected CartRepositoryInterface $quoteRepository,
        protected OrderRepositoryInterface $orderRepository,
        protected ConfigInterface $rallyConfig,
        protected OrderDataInterfaceFactory $orderDataFactory,
        protected ShippingLinesDataInterfaceFactory $shippingLinesDataFactory,
        protected Request $request,
        protected CartMapper $cartMapper,
        protected OrderSearchResultInterfaceFactory $searchResultFactory,
        protected OrdersListDataInterfaceFactory $ordersListFactory,
        protected ListOrderDataInterfaceFactory $listOrderFactory,
        protected ListOrderProductDataInterfaceFactory $listOrderProductFactory,
        protected array $orderDataMappers = []
    ) {
    }

    /**
     * Get order data
     *
     * @param string $externalId
     *
     * @return OrderDataInterface
     * @throws Exception
     * @throws NoSuchEntityException
     */
    public function getOrderData(string $externalId)
    {
        $orderData = $this->orderDataFactory->create();
        $orderId = $this->rallyConfig->getId($externalId);

        $order = $this->orderRepository->get($orderId);
        $quote = $this->quoteRepository->get($order->getQuoteId());

        $cartId = $this->rallyConfig->getFormattedId('quote', $quote->getId(), $quote->getCreatedAt());
        $orderStatus = $this->cartMapper->getMappedStatus($order->getStatus());
        $shippingCost = $this->getShippingCost($order);

        $orderData->setExternalId($externalId)
            ->setExternalNumber($order->getIncrementId())
            ->setCartId($cartId)
            ->setStatus($orderStatus)
            ->setSubtotal((float) $order->getSubtotal())
            ->setTotal((float) $order->getGrandTotal())
            ->setTaxAmount((float) $order->getTaxAmount())
            ->setShippingLines([$shippingCost])
            ->setShippingCost($shippingCost);

        foreach ($this->orderDataMappers as $method => $orderDataMapper) {
            $orderData->$method($orderDataMapper->getOrderData($order));
        }

        return $orderData;
    }

    /**
     * Get orders list
     *
     * @return OrdersListDataInterface
     * @throws Exception
     */
    public function getList(): OrdersListDataInterface
    {
        $listOrders = [];
        $perPage = $this->request->getParam('per_page') ?: 20;
        $currentPage = $this->request->getParam('current_page') ?: 1;

        $searchResult = $this->searchResultFactory->create()
            ->addAttributeToSort('entity_id', 'desc')
            ->setPage($currentPage, $perPage);

        foreach ($searchResult->getItems() as $order) {
            $orderData = $this->listOrderFactory->create();
            $orderId = $this->rallyConfig->getFormattedId('order', $order->getId(), $order->getCreatedAt());

            $orderItems = [];
            foreach ($order->getAllVisibleItems() as $item) {
                $itemData = $this->listOrderProductFactory->create();
                $itemData->setId($item->getProduct()->getId())
                    ->setName($item->getName());

                $orderItems[] = $itemData;
            }

            $orderData->setId($orderId)
                ->setCreatedAt(strtotime($order->getCreatedAt()))
                ->setProducts($orderItems);

            $listOrders[] = $orderData;
        }

        $ordersData = $this->ordersListFactory->create();
        $ordersData->setTotal($searchResult->getTotalCount())
            ->setPerPage($searchResult->getPageSize())
            ->setCurrentPage($searchResult->getCurPage())
            ->setData($listOrders);

        return $ordersData;
    }

    private function getShippingCost($order)
    {
        $externalId = $order->getShippingMethod();
        $title = $order->getShippingDescription();
        $shippingCode = explode('_', (string) $externalId);
        $price = (float) $order->getShippingAmount();
        $taxAmount = (float) $order->getShippingTaxAmount();
        $inclTax = (float) $order->getShippingInclTax();
        $taxRate = $price ? ($inclTax - $price) / $price : 0;

        $shippingData = $this->shippingLinesDataFactory->create();
        $shippingData->setExternalId($externalId)
            ->setTitle($title)
            ->setCarrierIdentifier($shippingCode[0] ?? '')
            ->setCode($shippingCode[1] ?? '')
            ->setDescription($title)
            ->setPrice($price)
            ->setSubtotal($price)
            ->setTaxRate(round($taxRate, 4))
            ->setTaxAmount($taxAmount)
            ->setTotal($inclTax);

        return $shippingData;
    }
}
