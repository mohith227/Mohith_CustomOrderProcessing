<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 7/3/25
 * Time: 11:52 AM
 */

namespace Mohith\CustomOrderProcessing\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class CustomOrderProcessing extends AbstractDb
{
    protected $_idFieldName = 'id';

    /**
     * CustomOrderProcessing constructor.
     *
     * @param Context $context
     * @param null $connectionName
     */
    public function __construct(Context $context, $connectionName = null)
    {
        parent::__construct($context, $connectionName);
    }

    protected function _construct()
    {
        $this->_init("custom_order_status_log", 'id');
    }
}