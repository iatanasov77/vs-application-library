<?php namespace Vankosoft\ApplicationBundle\Model\Interfaces;

use Sylius\Component\Resource\Model\ResourceInterface;
use Gedmo\Loggable\LogEntryInterface as BaseLogEntryInterface;

interface LogEntryInterface extends ResourceInterface, BaseLogEntryInterface
{
    public function getLocale();
}
