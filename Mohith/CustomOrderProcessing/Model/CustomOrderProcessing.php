<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 7/3/25
 * Time: 10:21 AM
 */

namespace Mohith\CustomOrderProcessing\Model;

use Magento\Framework\Model\AbstractModel;
use Mohith\CustomOrderProcessing\Api\Data\CustomOrderProcessingInterface;
use Mohith\CustomOrderProcessing\Model\ResourceModel\CustomOrderProcessing as CustomOrderProcessingResourceModel;

class CustomOrderProcessing  extends AbstractModel implements CustomOrderProcessingInterface
{
    const CACHE_TAG = 'custom_order_status';
    /**
     * @var string
     */
    protected $_cacheTag = 'custom_order_status';
    /**
     * @var string
     */
    protected $_eventPrefix = 'custom_order_status';

    /**
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    protected function _construct()
    {
        $this->_init(CustomOrderProcessingResourceModel::class);
    }
    /**
     * GetId
     *
     * @return string
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * GetOrderID
     *
     * @return string
     */
    public function getOrderID()
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * GetOldStatus
     *
     * @return string
     */
    public function getOldStatus()
    {
        return $this->getData(self::OLD_STATUS);
    }

    /**
     * GetNewStatus
     *
     * @return string
     */
    public function getNewStatus()
    {
        return $this->getData(self::NEW_STATUS);
    }

    /**
     * GetCreatedAt
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * GetUpdatedAt
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * SetId
     *
     * @param $id
     * @return CustomOrderProcessing
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * SetOrderID
     *
     * @param $orderId
     * @return CustomOrderProcessing
     */
    public function setOrderID($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * SetOldStatus
     *
     * @param $oldStatus
     * @return CustomOrderProcessing
     */
    public function setOldStatus($oldStatus)
    {
        return $this->setData(self::OLD_STATUS, $oldStatus);
    }


    /**
     * SetNewStatus
     *
     * @param $newStatus
     * @return CustomOrderProcessing
     */
    public function setNewStatus($newStatus)
    {
        return $this->setData(self::NEW_STATUS, $newStatus);
    }

    /**
     * SetCreatedAt
     *
     * @param $createdAt
     * @return CustomOrderProcessing
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * SetUpdatedAt
     *
     * @param $updatedAt
     * @return CustomOrderProcessing
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}