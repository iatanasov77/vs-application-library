<?php namespace Vankosoft\CmsBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ToggleableTrait;
use Vankosoft\CmsBundle\Model\Interfaces\QuickLinkInterface;
use Vankosoft\ApplicationBundle\Model\Traits\TranslatableTrait;
use Vankosoft\CmsBundle\Model\Interfaces\QuickLinksCategoryInterface;

class QuickLink implements QuickLinkInterface
{
    use ToggleableTrait;
    use TranslatableTrait;
    
    /** @var integer */
    protected $id;
    
    /** @var string */
    protected $linkText;
    
    /** @var string */
    protected $linkPath;
    
    /** @var string */
    protected $linkIconPath;
    
    /** @var Collection|QuickLinksCategory[] */
    protected $categories;
    
    public function __construct()
    {
        $this->fallbackLocale   = 'en_US';
        $this->categories       = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getLinkText(): ?string
    {
        return $this->linkText;
    }
    
    public function setLinkText($linkText)
    {
        $this->linkText   = $linkText;
        
        return $this;
    }
    
    public function getLinkPath(): ?string
    {
        return $this->linkPath;
    }
    
    public function setLinkPath($linkPath)
    {
        $this->linkPath  = $linkPath;
        
        return $this;
    }
    
    public function getLinkIconPath(): ?string
    {
        return $this->linkIconPath;
    }
    
    public function setLinkIconPath($linkIconPath)
    {
        $this->linkIconPath  = $linkIconPath;
        
        return $this;
    }
    
    public function isPublished(): ?bool
    {
        return $this->enabled;
    }
    
    public function getCategories(): Collection
    {
        return $this->categories;
    }
    
    public function addCategory( QuickLinksCategoryInterface $category ): self
    {
        if ( ! $this->categories->contains( $category ) ) {
            $this->categories[] = $category;
            $category->addQuickLink( $this );
        }
        
        return $this;
    }
    
    public function removeCategory( QuickLinksCategoryInterface $category ): self
    {
        if ( $this->categories->contains( $category ) ) {
            $this->categories->removeElement( $category );
            $category->removeQuickLink( $this );
        }
        
        return $this;
    }
}