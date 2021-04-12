<?php namespace VS\ApplicationBundle\Model\Interfaces;

use Sylius\Component\Resource\Model\ResourceInterface;

interface SiteInterface extends ResourceInterface
{
    public function getId();
    public function getTitle();
}
