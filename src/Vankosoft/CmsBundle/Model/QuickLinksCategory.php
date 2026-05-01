<?php namespace Vankosoft\CmsBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Vankosoft\ApplicationBundle\Model\Traits\TaxonDescendentTrait;
use Vankosoft\CmsBundle\Model\Interfaces\QuickLinksCategoryInterface;
use Vankosoft\CmsBundle\Model\Interfaces\QuickLinkInterface;

class QuickLinksCategory implements QuickLinksCategoryInterface
{
    use TaxonDescendentTrait;
    
    /** @var integer */
    protected $id;
    
    /** @var Collection|QuickLink[] */
    protected $quickLinks;
    
    public function __construct()
    {
        $this->quickLinks = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getPublishedQuickLinks(): Collection
    {
        return $this->getQuickLinks()->filter( function( QuickLinkInterface $quickLink )
        {
            return $quickLink->isPublished();
        });
    }
    
    public function getQuickLinks(): Collection
    {
        return $this->quickLinks;
    }
    
    public function addQuickLink( QuickLinkInterface $quickLink ): self
    {
        if ( ! $this->quickLinks->contains( $quickLink ) ) {
            $this->quickLinks[] = $quickLink;
            $quickLink->addPlace( $this );
        }
        
        return $this;
    }
    
    public function removeQuickLink( QuickLinkInterface $quickLink ): self
    {
        if ( $this->quickLinks->contains( $quickLink ) ) {
            $this->quickLinks->removeElement( $quickLink );
            $quickLink->removePlace( $this );
        }
        
        return $this;
    }
}
