<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 13/3/25
 * Time: 4:27 PM
 */

namespace Mohith\CustomOrderProcessing\Test\Unit\Model;


use PHPUnit\Framework\TestCase;
use Mohith\CustomOrderProcessing\Model\OrderStatusUpdate;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\Collection;
use Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory as StatusCollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\Status\Collection as StatusCollection;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Webapi\Exception as WebapiException;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Sales\Model\Order\StatusFactory;
use Magento\Store\Model\ScopeInterface;

class OrderStatusUpdateTest extends TestCase
{
    private $orderRepositoryMock;
    private $orderCollectionFactoryMock;
    private $orderCollectionMock;
    private $orderMock;
    private $statusCollectionFactoryMock;
    private $statusCollectionMock;
    private $scopeConfigMock;
    private $orderStatusUpdate;

    protected function setUp(): void
    {
        $this->orderRepositoryMock = $this->createMock(OrderRepositoryInterface::class);
        $this->orderCollectionFactoryMock = $this->createMock(CollectionFactory::class);
        $this->orderCollectionMock = $this->createMock(Collection::class);
        $this->orderMock = $this->createMock(Order::class);
        $this->statusCollectionFactoryMock = $this->createMock(StatusCollectionFactory::class);
        $this->statusCollectionMock = $this->createMock(StatusCollection::class);
        $this->scopeConfigMock = $this->createMock(ScopeConfigInterface::class);

        // Mock order collection behavior
        $this->orderCollectionFactoryMock->method('create')->willReturn($this->orderCollectionMock);
        $this->orderCollectionMock->method('addFieldToFilter')->willReturnSelf();
        $this->orderCollectionMock->method('setPageSize')->willReturnSelf();
        $this->orderCollectionMock->method('getFirstItem')->willReturn($this->orderMock);

        // Mock status collection
        $this->statusCollectionFactoryMock->method('create')->willReturn($this->statusCollectionMock);
        $this->statusCollectionMock->method('getColumnValues')->willReturn(['pending', 'processing', 'complete']);

        // Create an instance of OrderStatusUpdate with mock dependencies
        $this->orderStatusUpdate = new OrderStatusUpdate(
            $this->orderRepositoryMock,
            $this->orderCollectionFactoryMock,
            $this->createMock(\Magento\Sales\Api\OrderManagementInterface::class),
            $this->statusCollectionFactoryMock,
            $this->scopeConfigMock
        );
    }

    public function testUpdateStatusSuccessfully()
    {
        $incrementId = '000000007';
        $newStatus = 'processing';

        $this->orderMock->method('getId')->willReturn(1);
        $this->orderMock->method('getStatus')->willReturn('pending');

        $this->orderMock->expects($this->once())->method('setStatus')->with($newStatus);
        $this->orderRepositoryMock->expects($this->once())->method('save')->with($this->orderMock);

        $result = $this->orderStatusUpdate->updateStatus($incrementId, $newStatus);
        $this->assertEquals(__('Order status updated successfully.'), $result);
    }

    public function testUpdateStatusWithInvalidOrder()
    {
        $incrementId = '000000032';
        $newStatus = 'processing';

        // Order not found
        $this->orderMock->method('getId')->willReturn(null);

        $this->expectException(WebapiException::class);
        $this->expectExceptionMessage(__('Order not found.'));

        $this->orderStatusUpdate->updateStatus($incrementId, $newStatus);
    }

}