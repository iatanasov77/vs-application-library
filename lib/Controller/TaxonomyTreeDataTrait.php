<?php namespace VS\ApplicationBundle\Controller;

trait TaxonomyTreeDataTrait
{
    protected function gtreeTableData( $taxonomyId, $parentId, $displayRootTaxon = false ) : array
    {
        $ertt       = $this->getTaxonRepository();
        $ert        = $this->getTaxonomyRepository();
        $rootTaxon  = $ert->find( $taxonomyId )->getRootTaxon();
        
        if ( ! $parentId ) {
            $parentId   = $rootTaxon->getId();
        }
        $taxons         = $ertt->getTaxonsAsArray( $rootTaxon->getId(), $parentId );
        
        $gtreeTableData = $this->buildGtreeTableData( $taxons );
        
        if ( $displayRootTaxon && $parentId == $rootTaxon->getId() ) {
            array_unshift( $gtreeTableData, [
                'id'        => $rootTaxon->getId(),
                'name'      => $rootTaxon->getName(),
                'level'     => 0,
                'type'      => "RootTaxon"
            ]);
        }
        
        return ['nodes' => $gtreeTableData];
    }
    
    protected function easyuiComboTreeData( $taxonomyId, array $selectedValues = [], $displayRootTaxon = false ) : array
    {
        $rootTaxon      = $this->getTaxonomyRepository()->find( $taxonomyId )->getRootTaxon();
        $data           = [];
        
        if ( $displayRootTaxon ) {
            $data[0]        = [
                'id'        => $rootTaxon->getId(),
                'text'      => $rootTaxon->getName(),
                'children'  => []
            ];
            
            $this->buildEasyuiCombotreeData( $rootTaxon->getChildren(), $data[0]['children'], $selectedValues );
        } else {
            $this->buildEasyuiCombotreeData( $rootTaxon->getChildren(), $data, $selectedValues );
        }
        
        return $data;
    }
    
    protected function buildGtreeTableData( $taxons )
    {
        $data   = [];
        foreach ( $taxons as $t ) {
            $data[] = [
                'id'        => (int)$t['id'],
                'name'      => $t['name'],
                'level'     => (int)$t['tree_level'],
                'type'      => "default"
            ];
        }
        
        return $data;
    }
    
    protected function buildEasyuiCombotreeData( $tree, &$data, array $selectedValues )
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
                $this->buildEasyuiCombotreeData( $node->getChildren(), $data[$key]['children'], $selectedValues );
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
