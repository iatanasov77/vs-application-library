<?php namespace Vankosoft\CmsBundle\Model\Traits;

trait SeoMetadataTrait
{
    /** @var string | null */
    public ?string $metaDescription = null;
    
    /** @var string | null */
    public ?string $metaKeywords = null;
    
    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }
    
    public function setMetaDescription( ?string $metaDescription ): self
    {
        $this->metaDescription = $metaDescription;
        
        return $this;
    }
    
    public function getMetaKeywords(): ?string
    {
        return $this->metaKeywords;
    }
    
    public function setMetaKeywords( ?string $metaKeywords ): self
    {
        $this->metaKeywords = $metaKeywords;
        
        return $this;
    }
}
