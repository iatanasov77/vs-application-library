<?php namespace VS\ApplicationBundle\Model;

use Gedmo\Loggable\Entity\MappedSuperclass\AbstractLogEntry;
use VS\ApplicationBundle\Model\Interfaces\LogEntryInterface;

class LogEntry extends AbstractLogEntry implements LogEntryInterface
{
    
}
