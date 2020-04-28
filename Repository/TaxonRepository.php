<?php namespace VS\ApplicationBundle\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class TaxonRepository extends EntityRepository
{
    public function getTaxonsAsArray( $rootTaxonId, $parentId )
    {
        $em     = $this->getEntityManager();
        $sql    = "
            SELECT t.*, tt.* FROM APP_Taxons t LEFT JOIN APP_TaxonTranslations tt ON tt.translatable_id = t.id 
            WHERE tree_root=:rootTaxonId AND parent_id IS NOT NULL
        ";
        $params['rootTaxonId']  = $rootTaxonId;
        
        if ( $parentId ) {
            $sql    .= " AND parent_id = :parentId";
            $params['parentId'] = $parentId;
        }
        
        $statement = $em->getConnection()->prepare( $sql );
        $statement->execute( $params); 
        
        return $statement->fetchAll();
    }
    
    /*
     * @NOTE Native SQL: https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/native-sql.html
     *      ------------
     */
    public function getTaxons( $rootTaxon )
    {
        $em     = $this->getEntityManager();
        $rsm    = new ResultSetMappingBuilder( $em );
        
        $rsm->addRootEntityFromClassMetadata( get_class( $rootTaxon ), 'tt' );
        $sql = "
            SELECT * FROM APP_Taxons WHERE tree_root=?
        ";
        $query = $em->createNativeQuery( $sql, $rsm );
        $query->setParameter( 1, $rootTaxon->getId() );
        
        return $query->getResult();
    }
    
    /**
     * @NOTE NE STAVA
     */
    public function getTaxonsWithQueryBuilder( $rootTaxon )
    {
        // e tva ne stava be da go eba
        // $rootTaxon->getChildren();
        $qb = $this->createQueryBuilder( 'tt' );
        
        $query  = $qb->select( 'tt' )
                    ->where( 'tt.root = :rootTaxon' )
                    ->setParameter( 'rootTaxon', $rootTaxon )
                    ->getQuery();
        
        return $query->getResult();
    }
}
