<?php namespace Vankosoft\CmsBundle\Model\Interfaces;

interface SeoMetadataInterface
{
    public function getMetaDescription(): ?string;
    
    public function setMetaDescription( ?string $metaDescription ): self;
    
    public function getMetaKeywords(): ?string;
    
    public function setMetaKeywords( ?string $metaKeywords ): self;
}
