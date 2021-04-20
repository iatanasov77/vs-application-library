<?php namespace VS\ApplicationBundle\Controller;

trait TaxonomyTreeDataTrait
{
    protected function gtreeTableData( $taxonomyId, $parentId ) : array
    {
        $ertt           = $this->getTaxonRepository();
        $ert            = $this->getTaxonomyRepository();
        $rootTaxonId    = $ert->find( $taxonomyId )->getRootTaxon()->getId();
        
        if ( ! $parentId ) {
            $parentId   = $rootTaxonId;
        }
        $taxons         = $ertt->getTaxonsAsArray( $rootTaxonId, $parentId );
        
        $gtreeTableData = $this->buildGtreeTableData( $taxons );
        
        return [
            'nodes' => $gtreeTableData,
            //'readonly' => true
        ];
    }
    
    protected function easyuiComboTreeData( $taxonomyId, array $selectedValues = [], array $leafs = [] ) : array
    {
        $ert            = $this->getTaxonomyRepository();
        $rootTaxon      = $ert->find( $taxonomyId,  )->getRootTaxon();
        
        /*
        $data[0]        = [
            'id'        => $rootTaxon->getId(),
            'text'      => $rootTaxon->getName(),
            'children'  => []
        ];
        $this->buildEasyuiCombotreeData( $rootTaxon->getChildren(), $data[0]['children'] );
        */
        
        $data   = [];
        $this->buildEasyuiCombotreeData( $rootTaxon->getChildren(), $data, $selectedValues, $leafs );
        
        return $data;
    }
    
    protected function buildGtreeTableData( $taxons )
    {
        $data   = [];
        foreach ( $taxons as $t ) {
            $data[] = [
                'id'            => (int)$t['id'],
                'name'          => $t['name'],
                'level'         => (int)$t['tree_level'] - 1,
                'type'          => "default",
            ];
        }
        
        return $data;
    }
    
    protected function buildEasyuiCombotreeData( $tree, &$data, array $selectedValues, array $leafs )
    {
        $key    = 0;
        foreach( $tree as $node ) {
            $data[$key]   = [
                'id'        => $node->getId(),
                'text'      => $node->getName(),
                'children'  => []
            ];
            if ( in_array( $node->getId(), $selectedValues ) ) {
                $data[$key]['checked'] = true;
            }
            
            if ( $node->getChildren()->count() ) {
                $this->buildEasyuiCombotreeData( $node->getChildren(), $data[$key]['children'], $selectedValues, $leafs );
            }
            
            if ( array_key_exists( $node->getId(), $leafs ) ) {
                $this->buildEasyuiCombotreeData( $leafs[$node->getId()], $data[$key]['children'], $selectedValues, $leafs );
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
