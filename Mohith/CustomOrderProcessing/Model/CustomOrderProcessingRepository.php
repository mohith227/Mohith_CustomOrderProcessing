<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 7/3/25
 * Time: 11:44 AM
 */

namespace Mohith\CustomOrderProcessing\Model;

use Mohith\CustomOrderProcessing\Model\CustomOrderProcessing as Model;
use Mohith\CustomOrderProcessing\Model\ResourceModel\CustomOrderProcessing\Collection;
use Mohith\CustomOrderProcessing\Model\ResourceModel\CustomOrderProcessing\CollectionFactory;
use Mohith\CustomOrderProcessing\Api\CustomOrderProcessingRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Mohith\CustomOrderProcessing\Model\ResourceModel\CustomOrderProcessing as ResourceModel;
use Mohith\CustomOrderProcessing\Model\CustomOrderProcessingFactory as ModelFactory;

class CustomOrderProcessingRepository implements CustomOrderProcessingRepositoryInterface
{
    /**
     * @var ModelFactory
     */
    private $modelFactory;
    /**
     * @var ResourceModel
     */
    private $resourceModel;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * CustomOrderProcessingRepository constructor.
     *
     * @param CustomOrderProcessingFactory $modelFactory
     * @param ResourceModel $resourceModel
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        ModelFactory $modelFactory,
        ResourceModel $resourceModel,
        CollectionFactory $collectionFactory
    )
    {
        $this->modelFactory = $modelFactory;
        $this->resourceModel = $resourceModel;
        $this->collectionFactory = $collectionFactory;
    }


    /**
     * @param string $value
     * @param string $field
     * @throws NoSuchEntityException
     * @return Model
     */
    public function load($value, $field = self::ID_FIELD_NAME)
    {
        $model = $this->create();
        $this->resourceModel->load($model, $value, $field);
        if (!$model->getId()) {
            throw new NoSuchEntityException(__("Entity with $field = $value is Not Found"));
        }
        return $model;
    }

    /**
     * @param Model $model
     * @throws LocalizedException
     * @return Model
     */
    public function save(Model $model)
    {
        $this->resourceModel->save($model);
        return $model;
    }

    /**
     * @param Model $model
     * @throws \Exception
     * @return $this
     */
    public function delete(Model $model)
    {
        $this->resourceModel->delete($model);
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCollection()
    {
        return $this->collectionFactory->create();
    }

    /**
     * @return Model
     */
    public function create()
    {
        return $this->modelFactory->create();
    }
}