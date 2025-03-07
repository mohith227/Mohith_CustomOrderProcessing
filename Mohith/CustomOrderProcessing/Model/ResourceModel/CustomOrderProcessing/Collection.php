<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 7/3/25
 * Time: 11:54 AM
 */

namespace Mohith\CustomOrderProcessing\Model\ResourceModel\CustomOrderProcessing;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Mohith\CustomOrderProcessing\Model\CustomOrderProcessing as CustomOrderProcessingModel;
use Mohith\CustomOrderProcessing\Model\ResourceModel\CustomOrderProcessing as CustomOrderProcessingResourceModel;

class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(CustomOrderProcessingModel::class, CustomOrderProcessingResourceModel::class);
    }
}
