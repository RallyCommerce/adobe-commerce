<?php

namespace Rally\Checkout\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface for list order data
 */
interface ListOrderDataInterface extends ExtensibleDataInterface
{
    public const KEY_ID = 'id';
    public const KEY_CREATED_AT = 'created_at';
    public const KEY_PRODUCTS = 'products';

    /**
     * Get order id
     *
     * @return string
     */
    public function getId();

    /**
     * Set order id
     *
     * @param string $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get order created at
     *
     * @return int
     */
    public function getCreatedAt();

    /**
     * Set order created at
     *
     * @param int $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get order products
     *
     * @return \Rally\Checkout\Api\Data\ListOrderProductDataInterface[]
     */
    public function getProducts();

    /**
     * Set order products
     *
     * @param \Rally\Checkout\Api\Data\ListOrderProductDataInterface[] $products
     * @return $this
     */
    public function setProducts($products);
}
