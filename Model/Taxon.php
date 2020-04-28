<?php namespace VS\ApplicationBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Taxonomy\Model\Taxon as BaseTaxon;
use Sylius\Component\Resource\Model\TranslationInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Sylius\Component\Taxonomy\Model\TaxonTranslationInterface;

use VS\ApplicationBundle\Model\Interfaces\TaxonInterface as VsTaxonInterface;

/**
 * XML Mapping don't working
 * 
 * @ORM\MappedSuperclass
 */
class Taxon extends BaseTaxon implements VsTaxonInterface
{
    /**
     * @ORM\OneToOne(targetEntity="VS\ApplicationBundle\Model\Interfaces\TaxonomyInterface", mappedBy="rootTaxon")
     */
    protected $taxonomy;
    
    public function hasChild(TaxonInterface $taxon): bool
    {
        if ( ! $this->children ) {
            $this->children = new ArrayCollection();
        }
        return $this->children->contains($taxon);
    }
    
    public function getCurrentLocale()
    {
        return $this->currentLocale;
    }
    
    public function getTaxonomy()
    {
        return $this->taxonomy;
    }
}
