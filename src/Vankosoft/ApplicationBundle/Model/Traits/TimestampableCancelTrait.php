<?php namespace Vankosoft\ApplicationBundle\Model\Traits;

trait TimestampableCancelTrait
{
    protected $isTimestampableCanceled = false;
    
    public function cancelTimestampable( bool $cancel = true ): void
    {
        $this->isTimestampableCanceled = $cancel;
    }
    
    public function isTimestampableCanceled(): bool
    {
        return $this->isTimestampableCanceled;
    }
}
