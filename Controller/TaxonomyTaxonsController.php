<?php namespace VS\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use VS\ApplicationBundle\Component\Slug;
use VS\ApplicationBundle\Form\TaxonForm;

class TaxonomyTaxonsController extends Controller
{
    public function index( Request $request ): Response
    {
        return new Response( "NOT IMPLEMENTED !!!" );
    }
    
    public function editTaxon( Request $request ): Response
    {
        $locale     = $request->getLocale();
        $rootTaxon  = $this->getRootTaxon( $request->attributes->get( 'taxonomyId' ) );
        
        $oTaxon     = $this->get( 'vs_application.factory.taxon' )->createNew();
        $oTaxon->setCurrentLocale( $locale );
        
        $form   = $this->createForm( TaxonForm::class, $oTaxon, [
            'data'      => $oTaxon,
            'method'    => 'POST',
            'rootTaxon' => $rootTaxon
        ]);
        
        return $this->render( 'form/taxon.html.twig', [
            'form'          => $form->createView(),
            'taxonomyId'    => $request->attributes->get( 'taxonomyId' )
        ]);
    }
    
    public function handleTaxon( Request $request ): Response
    {
        $locale     = $request->getLocale();
        $form       = $this->createForm( TaxonForm::class );
        
        if ( $request->isMethod( 'POST' ) ) {
            $parentTaxon    = $this->getTaxon( $_POST['taxon_form']['parentTaxon'] );
            
            $form->submit( $request->request->get( $form->getName() ) );
            
            if ( $form->isSubmitted()  ) { // && $form->isValid()
                $em         = $this->getDoctrine()->getManager();
                $oTaxon     = $form->getData();
                $oTaxon->setParent( $parentTaxon );
                
                // @NOTE Force generation of slug
                $oTaxon->getTranslation( $locale )->setSlug( Slug::generate( $oTaxon->getTranslation()->getName() ) );
                $oTaxon->getTranslation( $locale )->setTranslatable( $oTaxon );
                
                $em->persist( $oTaxon );
                $em->flush();
                
                $taxonomyId = $request->attributes->get( 'taxonomyId' );
                return $this->redirect( $this->generateUrl( 'vs_application_taxonomy_update', ['id' => $taxonomyId] ) );
            }
        }
        
        return new Response( 'The form is not submited properly !!!', 500 );
    }
    
    public function gtreeTableSource( Request $request ): Response
    {
        $ertt           = $this->getTaxonRepository();
        $ert            = $this->getTaxonomyRepository();
        $rootTaxonId    = $ert->find( $request->attributes->get( 'id' ) )->getRootTaxon()->getId();

        $parentId       = (int)$request->query->get( 'taxonId' );
        $taxons         = $ertt->getTaxonsAsArray( $rootTaxonId, $parentId );
        //var_dump( $taxons ); die;
        $gtreeTableData = $this->buildGtreeTableData( $taxons );
        
        return new JsonResponse( ['nodes' => $gtreeTableData, 'readonly' => true] );
    }
    
    protected function getTaxonomyRepository()
    {
        return $this->get( 'vs_application.repository.taxonomy' );
    }
    
    protected function getTaxonRepository()
    {
        return $this->get( 'vs_application.repository.taxon' );
    }
    
    protected function buildGtreeTableData( $taxons )
    {
        $data   = [];
        foreach ( $taxons as $t ) {
            $data[] = [
                'id'    => (int)$t['id'],
                'name'  => $t['name'],
                'level' => $t['tree_level'],
                'type'  => "node type"
            ];
        }
        
        return $data;
    }
    
    protected function getRootTaxon( $taxonomyId )
    {
        return $this->get( 'vs_application.repository.taxonomy' )->find( $taxonomyId )->getRootTaxon();
    }
    
    protected function getTaxon( $taxonId )
    {
        return $this->get( 'vs_application.repository.taxon' )->find( $taxonId );
    }
}
