<?php

namespace Vendor\CustomOrderProcessing\Api;

interface UpdateOrderStatusManagementInterface
{

    /**
     * POST for UpdateOrderStatus api
     * @return string
     */
    public function updateOrderStatus(): string;
}

