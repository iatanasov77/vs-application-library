<?php namespace VS\ApplicationBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Taxonomy\Model\TaxonTranslation as BaseTaxonTranslation;

/**
 * @ORM\MappedSuperclass
 */
class TaxonTranslation extends BaseTaxonTranslation
{    
   
}
