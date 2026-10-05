<?php namespace Vankosoft\ApplicationBundle\Component;

interface MyLoggerInterface
{
    public function log( string $logData, ?string $context = null ): void;
}