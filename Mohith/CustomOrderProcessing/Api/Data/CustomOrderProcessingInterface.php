<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 7/3/25
 * Time: 10:09 AM
 */

namespace Mohith\CustomOrderProcessing\Api\Data;


interface CustomOrderProcessingInterface
{
    const ID = 'id';
    const ORDER_ID = 'order_id';
    const OLD_STATUS = 'old_status';
    const NEW_STATUS = 'new_status';
    const CREATED_AT = "creation_at";
    const UPDATED_AT = "updated_at";

    /**
     * GetId
     *
     * @return string
     */
    public function getId();

    /**
     * GetOrderID
     *
     * @return string
     */
    public function getOrderID();

    /**
     * GetOldStatus
     *
     * @return string
     */
    public function getOldStatus();

    /**
     * GetNewStatus
     *
     * @return string
     */
    public function getNewStatus();


    /**
     * GetCreatedAt
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * GetUpdatedAt
     *
     * @return string
     */
    public function getUpdatedAt();

    /**
     * SetId
     *
     * @param $id
     * @return CustomOrderProcessing
     */
    public function setId($id);

    /**
     * SetOrderID
     *
     * @param $orderId
     * @return CustomOrderProcessing
     */
    public function setOrderID($orderId);

    /**
     * SetOldStatus
     *
     * @param $oldStatus
     * @return CustomOrderProcessing
     */
    public function setOldStatus($oldStatus);


    /**
     * SetNewStatus
     *
     * @param $newStatus
     * @return CustomOrderProcessing
     */
    public function setNewStatus($newStatus);

    /**
     * SetCreatedAt
     *
     * @param $createdAt
     * @return CustomOrderProcessing
     */
    public function setCreatedAt($createdAt);

    /**
     * SetUpdatedAt
     *
     * @param $updatedAt
     * @return CustomOrderProcessing
     */
    public function setUpdatedAt($updatedAt);
}