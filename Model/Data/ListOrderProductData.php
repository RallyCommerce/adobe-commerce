<?php

namespace Rally\Checkout\Model\Data;

use Magento\Framework\Model\AbstractExtensibleModel;
use Rally\Checkout\Api\Data\ListOrderProductDataInterface;

class ListOrderProductData extends AbstractExtensibleModel implements ListOrderProductDataInterface
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
    public function getName()
    {
        return $this->getData(self::KEY_NAME);
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        return $this->setData(self::KEY_NAME, $name);
    }
}
