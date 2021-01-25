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
    
    public function editTaxon( $taxonomyId, Request $request ): Response
    {
        $locale     = $request->getLocale();
        $rootTaxon  = $this->getRootTaxon( $taxonomyId );
        
        $oTaxon     = $this->get( 'vs_application.factory.taxon' )->createNew();
        $oTaxon->setCurrentLocale( $locale );
        
        $form   = $this->createForm( TaxonForm::class, $oTaxon, [
            'data'      => $oTaxon,
            'method'    => 'POST',
            'rootTaxon' => $rootTaxon
        ]);
        
        return $this->render( '@VSApplication/Taxon/form/taxon.html.twig', [
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
    
    public function gtreeTableSource( $taxonomyId, Request $request ): Response
    {
        $ertt           = $this->getTaxonRepository();
        $ert            = $this->getTaxonomyRepository();
        $rootTaxonId    = $ert->find( $taxonomyId )->getRootTaxon()->getId();
        
        $parentId       = (int)$request->query->get( 'parentTaxonId' );
        $taxons         = $ertt->getTaxonsAsArray( $rootTaxonId, $parentId );

        $gtreeTableData = $this->buildGtreeTableData( $taxons );
        
        return new JsonResponse( ['nodes' => $gtreeTableData, 'readonly' => true] );
    }
    
    public function easyuiComboTreeSource( $taxonomyId, Request $request ): Response
    {
        $ert            = $this->getTaxonomyRepository();
        $rootTaxon      = $ert->find( $taxonomyId,  )->getRootTaxon();
        
        $data[0]        = [
            'id'        => $rootTaxon->getId(),
            'text'      => $rootTaxon->getName(),
            'children'  => []
        ];
        
        $this->buildEasyuiCombotreeData( $rootTaxon->getChildren(), $data[0]['children'] );
        
        return new JsonResponse( $data );
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
    
    protected function buildEasyuiCombotreeData( $tree, &$data )
    {
        $key    = 0;
        foreach( $tree as $node ) {
            $data[$key]   = [
                'id'        => $node->getId(),
                'text'      => $node->getName(),
                'children'  => []
            ];
            
            if ( $node->getChildren()->count() ) {
                $this->buildEasyuiCombotreeData( $node->getChildren(), $data[$key]['children'] );
            }
            
            $key++;
        }
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
