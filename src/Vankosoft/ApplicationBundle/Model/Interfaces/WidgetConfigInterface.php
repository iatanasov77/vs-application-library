<?php namespace Vankosoft\ApplicationBundle\Model\Interfaces;

use Sylius\Component\Resource\Model\ResourceInterface;
use Vankosoft\UsersBundle\Model\UserInterface;

interface WidgetConfigInterface extends ResourceInterface
{
    public function getOwner(): ?UserInterface;
    public function getConfig(): array;
}