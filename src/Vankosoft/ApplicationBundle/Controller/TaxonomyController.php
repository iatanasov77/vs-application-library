<?php namespace Vankosoft\ApplicationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Vankosoft\ApplicationBundle\Controller\AbstractCrudController;
use Vankosoft\ApplicationBundle\Component\Slug;

class TaxonomyController extends AbstractCrudController
{ 
    protected function prepareEntity( &$entity, &$form, Request $request )
    {
        $formData   = $request->request->get( 'taxonomy_form' );
        
        $entity->setCode( $this->get( 'vs_application.slug_generator' )->generate( $formData['name'] ) );
        
        if ( ! $entity->getRootTaxon() ) {
            $entity->setRootTaxon( $this->createRootTaxon( $entity, $request->getLocale() ) );
        }
    }
    
    protected function createRootTaxon( $taxonomy, $requestLocale )
    {
        $locale     = $taxonomy->getLocale() ?: $requestLocale;
        $rootTaxon  = $this->get( 'vs_application.factory.taxon' )->createNew();
        
        // @NOTE Force generation of slug
        $rootTaxon->setCurrentLocale( $locale );
        $rootTaxon->getTranslation()->setName( $taxonomy->getName() );
        $rootTaxon->getTranslation()->setDescription( 'Root taxon of Taxonomy: "' . $taxonomy->getName() . '"' );
        
        $slug   = $this->get( 'vs_application.slug_generator' )->generate( $taxonomy->getName() );
        $rootTaxon->setCode( $slug );
        $rootTaxon->getTranslation()->setSlug( $slug );
        
        $rootTaxon->getTranslation()->setTranslatable( $rootTaxon );
        
        return $rootTaxon;
    }
}
