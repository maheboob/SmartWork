<?php

namespace Vendor\CustomOrderProcessing\Model\ResourceModel\UpdateOrderStatus;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

   /** @var string  */
    protected $_idFieldName = 'status_id';


    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(
            \Vendor\CustomOrderProcessing\Model\UpdateOrderStatus::class,
            \Vendor\CustomOrderProcessing\Model\ResourceModel\UpdateOrderStatus::class
        );
    }
}

