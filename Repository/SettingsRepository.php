<?php namespace VS\ApplicationBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

use VS\ApplicationBundle\Model\Interfaces\SettingsInterface;

class SettingsRepository extends EntityRepository
{
    public function getSettings( $site )
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
    }
    
    public function getSettingsBySite( $siteId ): SettingsInterface
    {
        $conn   = $this->getEntityManager()->getConnection();
        
        $sql        = '
            SELECT s.id FROM VSORG_Settings AS s 
            LEFT JOIN VSORG_SettingsSites as ss ON ss.id = s.site_id
            WHERE ss.id = :siteId 
            ORDER BY s.id DESC 
            LIMIT 0, 1
        ';
        $stmt       = $conn->prepare( $sql );
        $stmt->execute( ['siteId' => $siteId] );
        
        $sBySite    = $stmt->fetch();
        
        return $sBySite ? $this->find( $sBySite['id'] ) : new Settings();
    }
    
    public function getGeneralSettings(): SettingsInterface
    {
        $conn   = $this->getEntityManager()->getConnection();
        
        $sql        = '
            SELECT s.id FROM VSORG_Settings AS s
            WHERE s.site_id IS NULL
            ORDER BY s.id DESC
            LIMIT 0, 1
        ';
        $stmt       = $conn->prepare( $sql );
        $stmt->execute();
        
        $sBySite    = $stmt->fetch();
        $oSettings  = $this->find( $sBySite['id'] );

        return $oSettings ?: new Settings();
    }
}
