<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 13/3/25
 * Time: 5:38 PM
 */

namespace Mohith\CustomOrderProcessing\Model\Indexer;

use Magento\Framework\Indexer\ActionInterface;
use Magento\Framework\Mview\ActionInterface as MviewActionInterface;
use Magento\Framework\App\ResourceConnection;
use Psr\Log\LoggerInterface;
use Zend_Db_Expr;
use Exception;

class OrderStatusIndexer implements ActionInterface, MviewActionInterface
{
    private $resource;
    private $logger;

    /**
     * OrderStatusIndexer constructor.
     *
     * @param ResourceConnection $resource
     * @param LoggerInterface $logger
     */
    public function __construct(
        ResourceConnection $resource,
        LoggerInterface $logger
    )
    {
        $this->resource = $resource;
        $this->logger = $logger;
    }

    /**
     * @param int[] $ids
     */
    public function execute($ids)
    {
        if (empty($ids)) {
            return;
        }

        try {
            $connection = $this->resource->getConnection();
            $tableName = $this->resource->getTableName('custom_order_status_log');

            $connection->update(
                $tableName,
                ['updated_at' => new Zend_Db_Expr('NOW()')],
                ['order_id IN (?)' => $ids]
            );
        } catch (Exception $e) {
            $this->logger->error(__('Order Status Indexer Error: %1', $e->getMessage()));
        }
    }

    public function executeFull()
    {
        $this->execute([]);
    }

    public function executeList(array $ids)
    {
        $this->execute($ids);
    }

    public function executeRow($id)
    {
        $this->execute([$id]);
    }
}