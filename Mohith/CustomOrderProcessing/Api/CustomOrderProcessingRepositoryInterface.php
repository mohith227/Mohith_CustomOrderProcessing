<?php
/**
 * Created by PhpStorm.
 * User: mohith
 * Date: 7/3/25
 * Time: 10:16 AM
 */

namespace Mohith\CustomOrderProcessing\Api;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Mohith\CustomOrderProcessing\Model\CustomOrderProcessing as Model;
use Mohith\CustomOrderProcessing\Model\ResourceModel\CustomOrderProcessing\Collection;

interface CustomOrderProcessingRepositoryInterface
{
    const ID_FIELD_NAME = "id";

    /**
     * @param string $value
     * @param string $field
     * @throws NoSuchEntityException
     * @return Model
     */
    public function load($value, $field = self::ID_FIELD_NAME);

    /**
     * @param Model $model
     * @throws LocalizedException
     * @return Model
     */
    public function save(Model $model);

    /**
     * @param Model $model
     * @throws \Exception
     * @return $this
     */
    public function delete(Model $model);

    /**
     * @return Collection
     */
    public function getCollection();

    /**
     * @return Model
     */
    public function create();
}