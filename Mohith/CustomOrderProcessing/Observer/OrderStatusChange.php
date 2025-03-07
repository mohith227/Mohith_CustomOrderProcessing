<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 7/3/25
 * Time: 12:33 PM
 */

namespace Mohith\CustomOrderProcessing\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Mohith\CustomOrderProcessing\Api\CustomOrderProcessingRepositoryInterface;
use Mohith\CustomOrderProcessing\Model\CustomOrderProcessingFactory;
use Magento\Sales\Model\Order;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class OrderStatusChange implements ObserverInterface
{
    protected $orderStatusLogRepository;
    protected $orderStatusLogFactory;
    protected $transportBuilder;
    protected $storeManager;
    protected $logger;

    /**
     * OrderStatusChange constructor.
     *
     * @param CustomOrderProcessingRepositoryInterface $orderStatusLogRepository
     * @param CustomOrderProcessingFactory $orderStatusLogFactory
     * @param TransportBuilder $transportBuilder
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        CustomOrderProcessingRepositoryInterface $orderStatusLogRepository,
        CustomOrderProcessingFactory $orderStatusLogFactory,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger
    ) {
        $this->orderStatusLogRepository = $orderStatusLogRepository;
        $this->orderStatusLogFactory = $orderStatusLogFactory;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
    }

    /**
     * Execute
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $oldStatus = $order->getOrigData('status');
        $newStatus = $order->getStatus();

        if ($oldStatus !== $newStatus) {
            try {

                $logEntry = $this->orderStatusLogFactory->create();
            $logEntry->setData([
                'order_id' => $order->getId(),
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
            ]);
            $this->orderStatusLogRepository->save($logEntry);
            } catch (\Exception $e) {
                $this->logger->error('Error in saving order status to custom module ' . $e->getMessage());
            }
            if ($newStatus === Order::STATE_COMPLETE || $newStatus === Order::ACTION_FLAG_SHIP) {
                try {
                    $store = $this->storeManager->getStore();
                    $transport = $this->transportBuilder
                        ->setTemplateIdentifier('order_shipped_template')
                        ->setTemplateOptions([
                            'area' => 'frontend',
                            'store' => $store->getId(),
                        ])
                        ->setTemplateVars(['order' => $order])
                        ->setFromByScope('general', $store->getId())
                        ->addTo($order->getCustomerEmail(), $order->getCustomerName())
                        ->getTransport();
                    $transport->sendMessage();
                } catch (\Exception $e) {
                    $this->logger->error('Order shipping email failed: ' . $e->getMessage());
                }
            }
        }
    }
}