<?php

namespace Rally\Checkout\Model\Data;

use Magento\Framework\Model\AbstractExtensibleModel;
use Rally\Checkout\Api\Data\ListOrderDataInterface;

class ListOrderData extends AbstractExtensibleModel implements ListOrderDataInterface
{
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getData(self::KEY_ID);
    }

    /**
     * @inheritdoc
     */
    public function setId($id)
    {
        return $this->setData(self::KEY_ID, $id);
    }

    /**
     * @inheritdoc
     */
    public function getCreatedAt()
    {
        return $this->getData(self::KEY_CREATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::KEY_CREATED_AT, $createdAt);
    }

    /**
     * @inheritdoc
     */
    public function getProducts()
    {
        return $this->getData(self::KEY_PRODUCTS);
    }

    /**
     * @inheritdoc
     */
    public function setProducts($products)
    {
        return $this->setData(self::KEY_PRODUCTS, $products);
    }
}
