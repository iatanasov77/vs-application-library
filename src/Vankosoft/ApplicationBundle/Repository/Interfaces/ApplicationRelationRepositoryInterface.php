<?php namespace Vankosoft\ApplicationBundle\Repository\Interfaces;

use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Vankosoft\ApplicationBundle\Model\Interfaces\ApplicationInterface;

interface ApplicationRelationRepositoryInterface extends RepositoryInterface
{
    public function findByApplication( ApplicationInterface $application ) : iterable;
}
