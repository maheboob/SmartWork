<?php

namespace Vendor\CustomOrderProcessing\Api\Data;

interface UpdateOrderStatusInterface
{

    const STATUS_ID = 'status_id';
    const ORDER_ID = 'order_id';
    const OLD_STATUS = 'old_status';
    const NEW_STATUS = 'new_status';
    const TIME_STAMP = 'time_stamp';

    /**
     * Get status_id
     * @return int|null
     */
    public function getStatusId();

    /**
     * Set status_id
     * @param int $statusId
     * @return \Vendor\CustomOrderProcessing\Api\Data\UpdateOrderStatusInterface
     */
    public function setStatusId(int $statusId);

    /**
     * Get order_id
     * @return int|null
     */
    public function getOrderId();

    /**
     * Set order_id
     * @param int $orderId
     * @return \Vendor\CustomOrderProcessing\Api\Data\UpdateOrderStatusInterface
     */
    public function setOrderId(int $orderId);

    /**
     * Get old_status
     * @return string|null
     */
    public function getOldStatus(): ?string;

    /**
     * Set old_status
     * @param string $oldStatus
     * @return \Vendor\CustomOrderProcessing\Api\Data\UpdateOrderStatusInterface
     */
    public function setOldStatus(string $oldStatus): UpdateOrderStatusInterface;

    /**
     * Get new_status
     * @return string|null
     */
    public function getNewStatus(): ?string;

    /**
     * Set new_status
     * @param string $newStatus
     * @return \Vendor\CustomOrderProcessing\Api\Data\UpdateOrderStatusInterface
     */
    public function setNewStatus(string $newStatus): UpdateOrderStatusInterface;

    /**
     * Get time_stamp
     * @return string|null
     */
    public function getTimeStamp(): ?string;

    /**
     * Set time_stamp
     * @param string $timeStamp
     * @return \Vendor\CustomOrderProcessing\Api\Data\UpdateOrderStatusInterface
     */
    public function setTimeStamp(string $timeStamp): UpdateOrderStatusInterface;
}

