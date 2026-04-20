<?php namespace Vankosoft\CmsBundle\Model\Traits;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

trait SeoMetadataEntity
{
    /** @var string | null */
    #[ORM\Column(type: Types::STRING, nullable: true)]
    public ?string $metaDescription = null;
    
    /** @var string | null */
    #[ORM\Column(type: Types::STRING, nullable: true)]
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
