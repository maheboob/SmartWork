<?php
declare(strict_types=1);

namespace Vendor\CustomOrderProcessing\Model;

use Magento\Framework\Model\AbstractModel;
use Vendor\CustomOrderProcessing\Api\Data\UpdateOrderStatusInterface;

class UpdateOrderStatus extends AbstractModel implements UpdateOrderStatusInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Vendor\CustomOrderProcessing\Model\ResourceModel\UpdateOrderStatus::class);
    }



    /**
     * @inheritDoc
     */
    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setOrderId(int $orderId): UpdateOrderStatus|UpdateOrderStatusInterface
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    public function getStatusId()
    {
        return $this->getData(self::STATUS_ID);
    }

    public function setStatusId(int $statusId): UpdateOrderStatus|UpdateOrderStatusInterface
    {
        return $this->setData(self::STATUS_ID, $statusId);
    }

    public function getOldStatus(): ?string
    {
        return $this->getData(self::OLD_STATUS);
    }

    public function setOldStatus(string $oldStatus): UpdateOrderStatusInterface
    {
        return $this->setData(self::OLD_STATUS, $oldStatus);
    }

    public function getNewStatus(): ?string
    {
        return $this->getData(self::NEW_STATUS);
    }

    public function setNewStatus(string $newStatus): UpdateOrderStatusInterface
    {
        return $this->setData(self::NEW_STATUS, $newStatus);
    }

    public function getTimeStamp(): ?string
    {
       return $this->getData(self::TIME_STAMP);
    }

    public function setTimeStamp(string $timeStamp): UpdateOrderStatusInterface
    {
       return $this->setData(self::TIME_STAMP, $timeStamp);
    }
}

