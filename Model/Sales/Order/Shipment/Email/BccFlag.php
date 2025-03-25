<?php
/**
 * 
 */
namespace FishPig\TrustPilotBccInvites\Model\Sales\Order\Shipment\Email;

class BccFlag
{
    /**
     * 
     */
    private $flag = false;

    /**
     * 
     */
    public function setFlag(bool $flag): void
    {
        $this->flag = $flag;
    }

    /**
     * 
     */
    public function getFlag(): bool
    {
        return $this->flag;
    }
}