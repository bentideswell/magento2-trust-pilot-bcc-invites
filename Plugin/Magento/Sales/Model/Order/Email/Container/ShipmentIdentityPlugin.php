<?php
/**
 * 
 */
namespace FishPig\TrustPilotBccInvites\Plugin\Magento\Sales\Model\Order\Email\Container;

use Magento\Sales\Model\Order\Email\Container\ShipmentIdentity;

class ShipmentIdentityPlugin
{
    /**
     * 
     */
    public function __construct(
        private \FishPig\TrustPilotBccInvites\Model\Sales\Order\Shipment\Email\BccFlag $emailBccFlag,
        private \FishPig\TrustPilotBccInvites\Model\Config $config
    ) {
    }

    /**
     * 
     */
    public function afterGetEmailCopyTo(
        ShipmentIdentity $subject,
        $result
    ) {
        if ($this->config->isEnabled()) {
            if ($this->emailBccFlag->getFlag()) {
                if (!$result) {
                    $result = [];
                }
                
                $result[] = $this->config->getShipmentBccEmail();
                $result = array_unique($result);
            }
        }

        return $result;
    }
}