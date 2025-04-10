<?php

namespace Vendor\CustomOrderProcessing\Api\Data;

interface UpdateOrderStatusSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get UpdateOrderStatus list.
     * @return \Vendor\CustomOrderProcessing\Api\Data\UpdateOrderStatusInterface[]
     */
    public function getItems();

    /**
     * Set order_id list.
     * @param \Vendor\CustomOrderProcessing\Api\Data\UpdateOrderStatusInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

