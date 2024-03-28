<?php

namespace Rally\Checkout\Api\Data;

/**
 * Interface for orders list data
 *
 * @api
 */
interface OrdersListDataInterface
{
    public const KEY_TOTAL = 'total';
    public const KEY_PER_PAGE = 'per_page';
    public const KEY_CURRENT_PAGE = 'current_page';
    public const KEY_DATA = 'data';

    /**
     * Get total order count
     *
     * @return int
     */
    public function getTotal();

    /**
     * Set total order count
     *
     * @param int $total
     * @return $this
     */
    public function setTotal($total);

    /**
     * Get order per page
     *
     * @return int
     */
    public function getPerPage();

    /**
     * Set order per page
     *
     * @param int $perPage
     * @return $this
     */
    public function setPerPage($perPage);

    /**
     * Get current page
     *
     * @return int
     */
    public function getCurrentPage();

    /**
     * Set current page
     *
     * @param int $currentPage
     * @return $this
     */
    public function setCurrentPage($currentPage);

    /**
     * Get orders data
     *
     * @return \Rally\Checkout\Api\Data\ListOrderDataInterface[]
     */
    public function getData();

    /**
     * Set orders data
     *
     * @param \Rally\Checkout\Api\Data\ListOrderDataInterface[] $data
     * @return $this
     */
    public function setData($data);
}
