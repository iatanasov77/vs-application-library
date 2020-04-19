<?php namespace VS\ApplicationBundle\Model\Interfaces;

use Sylius\Component\Resource\Model\ResourceInterface;

interface PageInterface extends ResourceInterface
{
    public function getSlug();
    public function getTitle();
    public function getText();
}
