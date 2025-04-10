<?php

namespace Vendor\CustomOrderProcessing\Model;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\OrderFactory;
use Vendor\CustomOrderProcessing\Api\UpdateOrderStatusManagementInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Webapi\Rest\Request;
use Vendor\CustomOrderProcessing\Model\UpdateOrderStatus;
use Vendor\CustomOrderProcessing\Model\UpdateOrderStatusRepository;


class UpdateOrderStatusManagement implements UpdateOrderStatusManagementInterface
{

    /** @var OrderRepositoryInterface */
    protected OrderRepositoryInterface $orderRepository;

    /** @var Order */
    protected Order $modelOrder;

    /** @var SerializerInterface */
    protected SerializerInterface $serializer;

    /** @var Request */
    protected Request $apiRequest;

    /** @var OrderFactory */
    protected OrderFactory $orderFactory;


    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param Order $order
     * @param SerializerInterface $serializer
     * @param Request $apiRequest
     * @param OrderFactory $orderFactory
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        Order                    $order,
        SerializerInterface      $serializer,
        Request                  $apiRequest,
        OrderFactory             $orderFactory
    )
    {
        $this->orderRepository = $orderRepository;
        $this->modelOrder = $order;
        $this->serializer = $serializer;
        $this->apiRequest = $apiRequest;
        $this->orderFactory = $orderFactory;
    }


    /**
     * @return string
     * @throws LocalizedException
     */
    public function updateOrderStatus(): string
    {
        $params = $this->apiRequest->getBodyParams();
        $message = '';
        if ($params !== null) {
            $incrementId = $params['increment_id'];
            $newStatus = $params['new_status'];
            try {
                $order = $this->orderFactory->create()->loadByIncrementId($incrementId);
                if (!$order->getEntityId()) {
                    throw new NoSuchEntityException(__('Order does not exist.'));
                }

                if (in_array($order->getStatus(), ['complete', 'closed'])) {
                    throw new LocalizedException(__('Cannot update status for completed or closed orders.'));
                }

                $order->setStatus($newStatus);
                $order->setState($newStatus);
                $this->orderRepository->save($order);

                $message = __('Order status updated successfully and the Current Status Is : ' . $order->getStatus());
            } catch (\Exception|LocalizedException|NoSuchEntityException $e) {
                throw new LocalizedException(__($e->getMessage()));
            }
        }
        return $message;
    }

}

