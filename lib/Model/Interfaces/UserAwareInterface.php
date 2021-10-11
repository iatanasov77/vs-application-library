<?php namespace VS\ApplicationBundle\Model\Interfaces;

use Sylius\Component\Resource\Model\ResourceInterface;
use VS\UsersBundle\Model\UserInterface;

interface UserAwareInterface extends ResourceInterface
{
    public function getUser() : ?UserInterface;
}
