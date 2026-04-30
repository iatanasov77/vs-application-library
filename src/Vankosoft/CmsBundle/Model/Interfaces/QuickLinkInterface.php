<?php namespace Vankosoft\CmsBundle\Model\Interfaces;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;
use Vankosoft\ApplicationBundle\Model\Interfaces\TranslatableInterface;

interface QuickLinkInterface extends
    ResourceInterface,
    TranslatableInterface
{
    public function getLinkText(): ?string;
    public function getLinkPath(): ?string;
    public function isPublished(): ?bool;
    public function getCategories(): Collection;
}
