<?php
/**
 * 
 */
namespace FishPig\TrustPilotBccInvites\Model\Sales\Order\Shipment;

use Magento\Sales\Model\Order\Shipment;

class Validator
{
    /**
     * 
     */
    private array $validators = [];

    /**
     * 
     */
    public function __construct(
        array $validators = []
    ) {
        foreach ($validators as $validator) {
            $this->addValidator($validator);
        }
    }

    /**
     * 
     */
    public function addValidator(ValidatorInterface $validator): void
    {
        $this->validators[] = $validator;
    }

    /**
     * 
     */
    public function isValid(Shipment $shipment): bool
    {
        try {
            foreach ($this->validators as $validator) {
                $validator->validate($shipment);
            }

            return true;
        } catch (ValidationException $e) {
            return false;
        }
    }
}