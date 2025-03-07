<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 7/3/25
 * Time: 2:52 PM
 */

namespace Mohith\CustomOrderProcessing\Model;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Framework\Webapi\Exception as WebapiException;
use Mohith\CustomOrderProcessing\Api\OrderStatusUpdateInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

class OrderStatusUpdate implements OrderStatusUpdateInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;
    /**
     * @var CollectionFactory
     */
    protected $orderCollectionFactory;
    /**
     * @var OrderManagementInterface
     */
    protected $orderManagement;

    /**
     * OrderStatusUpdate constructor.
     *
     * @param OrderRepositoryInterface $orderRepository
     * @param CollectionFactory $orderCollectionFactory
     * @param OrderManagementInterface $orderManagement
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CollectionFactory $orderCollectionFactory,
        OrderManagementInterface $orderManagement
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->orderManagement = $orderManagement;
    }

    /**
     * Update order status
     * @param string $incrementId
     * @param string $status
     * @return string
     */
    public function updateStatus($incrementId, $status)
    {
        try {
            $orderCollection = $this->orderCollectionFactory->create()
                ->addFieldToFilter('increment_id', $incrementId)
                ->setPageSize(1);

            $order = $orderCollection->getFirstItem();

            if (!$order->getId()) {
                throw new NoSuchEntityException(__('Order not found.'));
            }

            $order->setStatus($status);
            try{
                $this->orderRepository->save($order);
            }catch (\Exception $e){
                throw new NoSuchEntityException(__($e->getMessage()));

            }
            return 'Order status updated successfully.';
        } catch (NoSuchEntityException $e) {
            throw new WebapiException(__($e->getMessage()), 0, WebapiException::HTTP_NOT_FOUND);
        } catch (LocalizedException $e) {
            throw new WebapiException(__($e->getMessage()), 0, WebapiException::HTTP_BAD_REQUEST);
        }
    }
}
