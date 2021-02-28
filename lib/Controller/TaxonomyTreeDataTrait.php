<?php namespace VS\ApplicationBundle\Controller;

trait TaxonomyTreeDataTrait
{
    public function gtreeTableData( $taxonomyId, $parentId ) : array
    {
        $ertt           = $this->getTaxonRepository();
        $ert            = $this->getTaxonomyRepository();
        $rootTaxonId    = $ert->find( $taxonomyId )->getRootTaxon()->getId();
        
        $taxons         = $ertt->getTaxonsAsArray( $rootTaxonId, $parentId );
        
        $gtreeTableData = $this->buildGtreeTableData( $taxons );
        
        return ['nodes' => $gtreeTableData, 'readonly' => true];
    }
    
    public function easyuiComboTreeData( $taxonomyId ) : array
    {
        $ert            = $this->getTaxonomyRepository();
        $rootTaxon      = $ert->find( $taxonomyId,  )->getRootTaxon();
        
        $data[0]        = [
            'id'        => $rootTaxon->getId(),
            'text'      => $rootTaxon->getName(),
            'children'  => []
        ];
        
        $this->buildEasyuiCombotreeData( $rootTaxon->getChildren(), $data[0]['children'] );
        
        return $data;
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
    
    protected function getTaxonomyRepository()
    {
        return $this->get( 'vs_application.repository.taxonomy' );
    }
    
    protected function getTaxonRepository()
    {
        return $this->get( 'vs_application.repository.taxon' );
    }
}
