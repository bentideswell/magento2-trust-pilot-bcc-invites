<?php
/**
 * 
 */
namespace FishPig\TrustPilotBccInvites\Model;

class Config
{
    /**
     * 
     */
    public function __construct(
        private string $username = '',
        private string $bccEmail = ''
    ) {
    }

    /**
     * 
     */
    public function isEnabled(): bool
    {
        return $this->getShipmentBccEmail()
                && strpos($this->getShipmentBccEmail(), '@') !== false;
    }

    /**
     * 
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * 
     */
    public function getProfileUrl(): string
    {
        return 'https://uk.trustpilot.com/review/' . $this->getUsername();
    }

    /**
     * 
     */
    public function getShipmentBccEmail(): string
    {
        return $this->bccEmail;
    }
}