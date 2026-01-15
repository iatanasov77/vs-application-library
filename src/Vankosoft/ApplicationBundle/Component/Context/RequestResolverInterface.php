<?php namespace Vankosoft\ApplicationBundle\Component\Context;

use Vankosoft\ApplicationBundle\Model\Interfaces\ApplicationInterface;

interface RequestResolverInterface
{
    public function findApplication( string $host ) : ?ApplicationInterface;
}
