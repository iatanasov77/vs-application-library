<?php namespace VS\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class TaxonomyTaxonsController extends Controller
{
    public function index( Request $request ): Response
    {
        return new Response( "NOT IMPLEMENTED !!!" );
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
}
