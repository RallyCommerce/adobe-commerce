<?php

namespace Rally\Checkout\Model\Data;

use Rally\Checkout\Api\Data\OrdersListDataInterface;

class OrdersListData implements OrdersListDataInterface
{
    private array $data = [];

    /**
     * @inheritdoc
     */
    public function getTotal()
    {
        return $this->get(self::KEY_TOTAL);
    }

    /**
     * @inheritdoc
     */
    public function setTotal($total)
    {
        return $this->set(self::KEY_TOTAL, $total);
    }

    /**
     * @inheritdoc
     */
    public function getPerPage()
    {
        return $this->get(self::KEY_PER_PAGE);
    }

    /**
     * @inheritdoc
     */
    public function setPerPage($perPage)
    {
        return $this->set(self::KEY_PER_PAGE, $perPage);
    }

    /**
     * @inheritdoc
     */
    public function getCurrentPage()
    {
        return $this->get(self::KEY_CURRENT_PAGE);
    }

    /**
     * @inheritdoc
     */
    public function setCurrentPage($currentPage)
    {
        return $this->set(self::KEY_CURRENT_PAGE, $currentPage);
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        return $this->get(self::KEY_DATA);
    }

    /**
     * @inheritdoc
     */
    public function setData($data)
    {
        return $this->set(self::KEY_DATA, $data);
    }

    /**
     * Return data Object data.
     *
     * @return mixed
     */
    private function get($key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Overwrite data in Object.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     */
    private function set($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }
}
