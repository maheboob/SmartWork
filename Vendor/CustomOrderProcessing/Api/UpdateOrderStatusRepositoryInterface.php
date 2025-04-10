<?php
declare(strict_types=1);

namespace Vendor\CustomOrderProcessing\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Vendor\CustomOrderProcessing\Api\Data\UpdateOrderStatusInterface;
use Vendor\CustomOrderProcessing\Api\Data\UpdateOrderStatusSearchResultsInterface;

interface UpdateOrderStatusRepositoryInterface
{

    /**
     * Save UpdateOrderStatus
     * @param UpdateOrderStatusInterface $updateOrderStatus
     * @return UpdateOrderStatusInterface
     * @throws LocalizedException
     */
    public function save(
        UpdateOrderStatusInterface $updateOrderStatus
    );

    /**
     * Retrieve UpdateOrderStatus
     * @param int $statusId
     * @return UpdateOrderStatusInterface
     * @throws LocalizedException
     */
    public function get($statusId);

    /**
     * Retrieve UpdateOrderStatus matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return UpdateOrderStatusSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete UpdateOrderStatus
     * @param UpdateOrderStatusInterface $updateOrderStatus
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(
        UpdateOrderStatusInterface $updateOrderStatus
    );

    /**
     * Delete UpdateOrderStatus by ID
     * @param int $statusId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($statusId);
}

