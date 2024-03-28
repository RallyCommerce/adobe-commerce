<?php

namespace Rally\Checkout\Api\Data;

/**
 * Interface ListOrderProductDataInterface
 */
interface ListOrderProductDataInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    public const KEY_ID = 'id';
    public const KEY_NAME = 'name';

    /**
     * Get product ID
     *
     * @return string
     */
    public function getId();

    /**
     * Set product ID
     *
     * @param string $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get product name
     *
     * @return string
     */
    public function getName();

    /**
     * Set product name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);
}
