<?php
declare(strict_types=1);

namespace Vendor\CustomOrderProcessing\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Vendor\CustomOrderProcessing\Api\Data\UpdateOrderStatusInterface;
use Vendor\CustomOrderProcessing\Api\Data\UpdateOrderStatusInterfaceFactory;
use Vendor\CustomOrderProcessing\Api\Data\UpdateOrderStatusSearchResultsInterfaceFactory;
use Vendor\CustomOrderProcessing\Api\UpdateOrderStatusRepositoryInterface;
use Vendor\CustomOrderProcessing\Model\ResourceModel\UpdateOrderStatus as ResourceUpdateOrderStatus;
use Vendor\CustomOrderProcessing\Model\ResourceModel\UpdateOrderStatus\CollectionFactory as UpdateOrderStatusCollectionFactory;

class UpdateOrderStatusRepository implements UpdateOrderStatusRepositoryInterface
{

    /**
     * @var ResourceUpdateOrderStatus
     */
    protected $resource;

    /**
     * @var UpdateOrderStatusInterfaceFactory
     */
    protected $updateOrderStatusFactory;

    /**
     * @var UpdateOrderStatusCollectionFactory
     */
    protected $updateOrderStatusCollectionFactory;

    /**
     * @var UpdateOrderStatus
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;


    /**
     * @param ResourceUpdateOrderStatus $resource
     * @param UpdateOrderStatusInterfaceFactory $updateOrderStatusFactory
     * @param UpdateOrderStatusCollectionFactory $updateOrderStatusCollectionFactory
     * @param UpdateOrderStatusSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceUpdateOrderStatus $resource,
        UpdateOrderStatusInterfaceFactory $updateOrderStatusFactory,
        UpdateOrderStatusCollectionFactory $updateOrderStatusCollectionFactory,
        UpdateOrderStatusSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->updateOrderStatusFactory = $updateOrderStatusFactory;
        $this->updateOrderStatusCollectionFactory = $updateOrderStatusCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(
        UpdateOrderStatusInterface $updateOrderStatus
    ) {
        try {
            $this->resource->save($updateOrderStatus);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the updateOrderStatus: %1',
                $exception->getMessage()
            ));
        }
        return $updateOrderStatus;
    }

    /**
     * @inheritDoc
     */
    public function get($statusId)
    {
        $updateOrderStatus = $this->updateOrderStatusFactory->create();
        $this->resource->load($updateOrderStatus, $statusId);
        if (!$updateOrderStatus->getId()) {
            throw new NoSuchEntityException(__('UpdateOrderStatus with id "%1" does not exist.', $statusId));
        }
        return $updateOrderStatus;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->updateOrderStatusCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(
        UpdateOrderStatusInterface $updateOrderStatus
    ) {
        try {
            $updateOrderStatusModel = $this->updateOrderStatusFactory->create();
            $this->resource->load($updateOrderStatusModel, $updateOrderStatus->getStatusId());
            $this->resource->delete($updateOrderStatusModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the UpdateOrderStatus: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($statusId)
    {
        return $this->delete($this->get($statusId));
    }

    /**
     * @inheritDoc
     */
    public function getOrderStatusByOrderId($orderId)
    {
        $updateOrderStatus = $this->updateOrderStatusFactory->create();
        $this->resource->load($updateOrderStatus, $orderId,'order_id');
       /* if (!$updateOrderStatus->getStatusId()) {
            throw new NoSuchEntityException(__('UpdateOrderStatus with order id "%1" does not exist.', $orderId));
        }*/
        return $updateOrderStatus;
    }
}

