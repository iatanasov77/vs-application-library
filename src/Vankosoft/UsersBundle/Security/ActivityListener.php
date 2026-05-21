<?php namespace Vankosoft\UsersBundle\Security;

use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Doctrine\ORM\EntityManagerInterface;
use Vankosoft\UsersBundle\Model\Interfaces\UserInterface;

/**
 * Listener that updates the last activity of the authenticated user
 */
class ActivityListener
{
    /** @var SecurityBridge */
    protected $securityBridge;
    
    /** @var EntityManagerInterface */
    protected $entityManager;
    
    public function __construct( SecurityBridge $securityBridge, EntityManagerInterface $entityManager )
    {
        $this->securityBridge   = $securityBridge;
        $this->entityManager    = $entityManager;
    }
    
    /**
     * Update the user "lastActivity" on each request
     * @param FilterControllerEvent $event
     */
    public function onCoreController( ControllerEvent $event )
    {
        // Check that the current request is a "MASTER_REQUEST"
        // Ignore any sub-request
        if ( $event->getRequestType() !== HttpKernel::MASTER_REQUEST ) {
            return;
        }
        $user = $this->securityBridge->getUser();
        
        // Check token authentication availability
        if ( $user && ( $user instanceof UserInterface ) && ! ( $user->isActiveNow() ) ) {
            $user->setLastActivityAt( new \DateTime() );
            $this->entityManager->flush( $user );
        }
    }
}
