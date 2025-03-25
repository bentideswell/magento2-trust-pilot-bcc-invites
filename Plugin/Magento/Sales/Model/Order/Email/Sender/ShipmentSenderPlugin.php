<?php
/**
 * 
 */
namespace FishPig\TrustPilotBccInvites\Plugin\Magento\Sales\Model\Order\Email\Sender;

use Magento\Sales\Model\Order\Email\Sender\ShipmentSender;
use Magento\Sales\Model\Order\Shipment;

class ShipmentSenderPlugin
{
    /**
     * 
     */
    public function __construct(
        private \FishPig\TrustPilotBccInvites\Model\Sales\Order\Shipment\Validator $trustPilotShipmentValidator,
        private \FishPig\TrustPilotBccInvites\Model\Sales\Order\Shipment\Email\BccFlag $emailBccFlag,
    ) {

    }

    /**
     * 
     */
    public function aroundSend(
        ShipmentSender $subject,
        callable $proceed,
        Shipment $shipment, 
        $forceSyncMode = false
    ) {
        try {
            $this->emailBccFlag->setFlag(
                $this->trustPilotShipmentValidator->isValid($shipment)
            );

            return $proceed($shipment, $forceSyncMode);
        } finally {
            if ($this->emailBccFlag->getFlag()) {
                $shipment->getOrder()->addStatusHistoryComment(
                    sprintf(
                        'TrustPilot email sent via BCC to %s',
                        $this->getShipmentBccEmail()
                    )
                )->setIsCustomerNotified(false)->save();
            }

            $this->emailBccFlag->setFlag(false);
        }
    }

    /**
     * 
     */
    private function getShipmentBccEmail()
    {
        return \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\FW\TrustPilot\Model\Config::class)
            ->getShipmentBccEmail();
    }
}