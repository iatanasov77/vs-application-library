<?php namespace Vankosoft\ApplicationBundle\Model\Interfaces;

interface TimestampableCancelInterface
{
    public function isTimestampableCanceled(): bool;
}
