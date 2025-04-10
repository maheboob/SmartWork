<?php

namespace Vendor\CustomOrderProcessing\Observer\Sales;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Vendor\CustomOrderProcessing\Model\UpdateOrderStatus;
use Vendor\CustomOrderProcessing\Model\UpdateOrderStatusRepository;
use Magento\Sales\Model\Order\Shipment\Sender\EmailSender;
use Magento\Sales\Model\Convert\Order as ConvertOrder;

class OrderSaveAfter implements ObserverInterface
{
    /** @var LoggerInterface */
    protected LoggerInterface $logger;

    /** @var UpdateOrderStatusRepository */
    protected UpdateOrderStatusRepository $updateOrderStatusRepository;

    /** @var UpdateOrderStatus */
    protected UpdateOrderStatus $modelUpdateOrderStatus;

    /** @var EmailSender */
    protected EmailSender $emailSender;

    /** @var ConvertOrder */
    protected ConvertOrder $convertOrder;

    /**
     * @param LoggerInterface $logger
     * @param UpdateOrderStatusRepository $updateOrderStatusRepository
     * @param UpdateOrderStatus $modelUpdateOrderStatus
     * @param EmailSender $emailSender
     * @param ConvertOrder $convertOrder
     */
    public function __construct(
        LoggerInterface             $logger,
        UpdateOrderStatusRepository $updateOrderStatusRepository,
        UpdateOrderStatus           $modelUpdateOrderStatus,
        EmailSender                 $emailSender,
        ConvertOrder                $convertOrder
    )
    {
        $this->logger = $logger;
        $this->updateOrderStatusRepository = $updateOrderStatusRepository;
        $this->modelUpdateOrderStatus = $modelUpdateOrderStatus;
        $this->emailSender = $emailSender;
        $this->convertOrder = $convertOrder;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     * @throws LocalizedException
     */
    public function execute(Observer $observer): void
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getOrder();
        $origData = $order->getOrigData();

        $this->logger->debug('logged');

        $data = ['order_id' => $order->getIncrementId(),
            'old_status' => $origData['status'] ?? 'N/A',
            'new_status' => $order->getStatus()];

        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/status.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info('Test the log');
        $logger->info(print_r($data, true));

        $this->getSaveUpdateOrderStatus($data);

        if ($order->hasShipments()) {
            $shipment = $this->convertOrder->toShipment($order);
            try {
                $shipment->register();
                $shipment->getOrder()->setIsInProcess(true);
                $shipment->save();
                $shipment->getOrder()->save();
                $this->emailSender->send($order, $shipment);
            } catch (\Exception $e) {
                throw new LocalizedException(__($e->getMessage()));
            }
        }
    }


    /**
     * @param array $dataArray
     * @return void
     * @throws LocalizedException
     */
    public function getSaveUpdateOrderStatus(array $dataArray): void
    {
        $modelOrderStatus = $this->modelUpdateOrderStatus;
        $orderStatusRepo = $this->updateOrderStatusRepository;
        $orderStatus = $orderStatusRepo->getOrderStatusByOrderId($dataArray['order_id']);
        try {
            if ($orderStatus->getStatusId() == '') {
                $data = ['old_status' => $dataArray['old_status'], 'new_status' => $dataArray['new_status'], 'order_id' => $dataArray['order_id']];
                $modelOrderStatus->setData($data);
                $orderStatusRepo->save($modelOrderStatus);
            } else {
                $orderStatus->setOldStatus($dataArray['old_status']);
                $orderStatus->setNewStatus($dataArray['new_status']);
                $orderStatusRepo->save($orderStatus);
            }
        } catch (LocalizedException $e) {
            throw new LocalizedException(__($e->getMessage()));
        }
    }
}

