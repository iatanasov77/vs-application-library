<?php namespace Vankosoft\CmsBundle\Model\Interfaces;

use Sylius\Component\Resource\Model\ResourceInterface;
use Vankosoft\ApplicationBundle\Model\Interfaces\TaxonDescendentInterface;
use Doctrine\Common\Collections\Collection;

interface QuickLinksCategoryInterface extends ResourceInterface, TaxonDescendentInterface
{
    public function getPublishedQuickLinks(): Collection;
    public function getQuickLinks(): Collection;
    public function addQuickLink( QuickLinkInterface $banner ): self;
    public function removeQuickLink( QuickLinkInterface $banner ): self;
}