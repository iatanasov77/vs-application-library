<?php namespace VS\ApplicationBundle\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

use VS\ApplicationBundle\Model\Interfaces\SettingsInterface;

class SettingsRepository extends EntityRepository implements ContainerAwareInterface
{
    use ContainerAwareTrait;
    
    public function getSettings( $site = null ): ?SettingsInterface
    {
        /**
         * @NOTE $this->container is NULL i dont know why and i cannot use it for now
         */
        
        $qb = $this->createQueryBuilder( 's' )
                    
                    ->orderBy( 's.id', 'DESC' )
                    ->setMaxResults( 1 )
                    ->setFirstResult( 0 );
        
        if ( $site == null ) {
            $qb->where( 's.site IS NULL' );
        } else {
            $qb->leftJoin( 's.site', 'ss' )
                ->where( 'ss.site = :site' )->setParameter( 'site', $site );
        }
        $result = $qb->getQuery()->getResult();
        
        return isset( $result[0] ) ? $result[0] : null;
    }
}
