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
        private \FishPig\TrustPilotBccInvites\Model\Config $config
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

            $result = $proceed($shipment, $forceSyncMode);

            if ($this->emailBccFlag->getFlag()) {
                $shipment->getOrder()->addStatusHistoryComment(
                    sprintf(
                        'TrustPilot email sent via BCC to %s',
                        $this->getShipmentBccEmail()
                    )
                )->setIsCustomerNotified(false)->save();
            }

            return $result;
        } catch (\Throwable $e) {
            $this->emailBccFlag->setFlag(false);
        }
    }

    /**
     * 
     */
    private function getShipmentBccEmail()
    {
        return $this->config->getShipmentBccEmail();
    }
}