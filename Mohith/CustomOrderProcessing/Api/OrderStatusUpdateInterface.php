<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 7/3/25
 * Time: 2:51 PM
 */

namespace Mohith\CustomOrderProcessing\Api;


interface OrderStatusUpdateInterface
{
    /**
     * Update order status
     * @param string $incrementId
     * @param string $status
     * @return string
     */
    public function updateStatus($incrementId, $status);
}