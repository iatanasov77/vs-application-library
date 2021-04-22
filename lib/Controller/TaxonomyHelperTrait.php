<?php namespace VS\ApplicationBundle\Controller;

trait TaxonomyHelperTrait
{
    protected function createTaxon( $name, $locale, $parent, $taxonomyId )
    {
        $taxon  = $this->get( 'vs_application.factory.taxon' )->createNew();
        
        $taxon->setCurrentLocale( $locale );
        $taxon->setName( $name );
        
        if ( ! $parent ) {
            $taxonomy   = $this->get( 'vs_application.repository.taxonomy' )->find( $taxonomyId );
            $parent     = $taxonomy->getRootTaxon();
        }
        $taxon->setParent( $parent );
        
        return $taxon;
    }
}
