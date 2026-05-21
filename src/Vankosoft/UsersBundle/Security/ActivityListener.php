<?php namespace Vankosoft\UsersBundle\Security;

use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Doctrine\ORM\EntityManagerInterface;
use Vankosoft\UsersBundle\Model\Interfaces\UserInterface;

/**
 * Listener that updates the last activity of the authenticated user
 * Manual: https://stackoverflow.com/questions/21096689/symfony-how-to-return-all-logged-in-active-users
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
     * @param ControllerEvent $event
     */
    public function onCoreController( ControllerEvent $event )
    {
        // Check that the current request is a "MASTER_REQUEST"
        // Ignore any sub-request
        if ( $event->getRequestType() !== HttpKernelInterface::MAIN_REQUEST ) {
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
