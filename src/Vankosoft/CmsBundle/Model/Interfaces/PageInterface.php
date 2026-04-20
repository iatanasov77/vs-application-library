<?php namespace Vankosoft\CmsBundle\Model\Interfaces;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\SlugAwareInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;
use Vankosoft\ApplicationBundle\Model\Interfaces\TranslatableInterface;

interface PageInterface extends
    ResourceInterface,
    SlugAwareInterface,
    TimestampableInterface,
    ToggleableInterface,
    TranslatableInterface,
    SeoMetadataInterface
{
    public function getCategories(): Collection;
    
    public function addCategory( PageCategoryInterface $category ): self;
    
    public function removeCategory( PageCategoryInterface $category ): self;
    
    public function getSlug(): ?string;
    
    public function getTitle(): ?string;
    
    public function getText(): ?string;
    
    public function getPublished(): ?bool;
}
