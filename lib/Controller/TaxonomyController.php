<?php namespace VS\ApplicationBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use VS\ApplicationBundle\Component\Slug;

class TaxonomyController extends ResourceController
{
    public function indexAction( Request $request ) : Response
    {
        return $this->render( '@VSApplication/Taxonomy/index.html.twig', [
            'items' => $this->getRepository()->findAll()
        ]);
    }
    
    public function createAction( Request $request ): Response
    {
        $oTaxonomy  = $this->getFactory()->createNew();
        
        return $this->edit( $request, $oTaxonomy );
    }
    
    public function updateAction( Request $request ): Response
    {
        $oTaxonomy  = $this->getRepository()->find( $request->attributes->get( 'id' ) );
        
        return $this->edit( $request, $oTaxonomy );
    }
    
    protected function edit( Request $request, ResourceInterface $oTaxonomy )
    {//var_dump($request->getLocale()); die;
        $configuration  = $this->requestConfigurationFactory->create( $this->metadata, $request );        
        $form           = $this->resourceFormFactory->create( $configuration, $oTaxonomy );

        if ( in_array( $request->getMethod(), ['POST', 'PUT', 'PATCH'], true ) && $form->handleRequest( $request)->isValid() ) {
            $taxonomy   = $form->getData();
            
            if ( ! $taxonomy->getRootTaxon() ) {
                $taxonomy->setRootTaxon( $this->createRootTaxon( $taxonomy ) );
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist( $taxonomy );
            $em->flush();
            
            return $this->redirect($this->generateUrl( 'vs_application_taxonomy_index' ));
        }
        
        return $this->render( '@VSApplication/Taxonomy/edit.html.twig', [
            'form'  => $form->createView(),
            'item'  => $oTaxonomy
        ]);
    }
    
    protected function getRepository()
    {
        return $this->get( 'vs_application.repository.taxonomy' );
    }
    
    protected function getFactory()
    {
        return $this->get( 'vs_application.factory.taxonomy' );
    }
    
    protected function createRootTaxon( $taxonomy )
    {
        $locale     = $taxonomy->getLocale() ?: 'en';
        $rootTaxon  = $this->get( 'vs_application.factory.taxon' )->createNew();
        
        // @NOTE Force generation of slug
        $rootTaxon->setCurrentLocale( $locale );
        $rootTaxon->getTranslation()->setName( $taxonomy->getName() );
        $rootTaxon->getTranslation()->setDescription( 'Root taxon of Taxonomy: "' . $taxonomy->getName() . '"' );
        $rootTaxon->getTranslation()->setSlug( Slug::generate( $taxonomy->getName() ) );
        $rootTaxon->getTranslation()->setTranslatable( $rootTaxon );
        
        return $rootTaxon;
    }
}
