<?php
/**
 * 
 */
namespace FishPig\TrustPilotBccInvites\Model\Sales\Order\Shipment;

interface ValidatorInterface
{
    /**
     * 
     */
    public function validate(\Magento\Sales\Model\Order\Shipment $shipment): void;
}