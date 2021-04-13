<?php namespace VS\ApplicationBundle\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

use VS\ApplicationBundle\Model\Interfaces\SettingsInterface;

class SettingsRepository extends EntityRepository implements SettingsRepositoryInterface, ContainerAwareInterface
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
                ->setFirstResult( 0 )
        ;
        if ( $site ) {
            $qb->where( 's.site = :site' )->setParameter( 'site', $site );
        } else {
            $qb->where( 's.site IS NULL' );
        }
        $result = $qb->getQuery()->getResult();
        
        return isset( $result[0] ) ? $result[0] : null;
    }
}
