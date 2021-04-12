<?php namespace VS\ApplicationBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

use VS\ApplicationBundle\Twig\Alerts;

class MaintenanceListener
{
    protected $container;
    protected $user;
    protected $siteId;
    
    public function __construct( ContainerInterface $container, int $siteId = null )
    {
        $this->container    = $container;
        $this->siteId       = $siteId;
        
        $token              = $this->container->get( 'security.token_storage' )->getToken();
        if ( $token ) {
            $this->user         = $token->getUser();
        }
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        $site   = null;
        if ( $this->siteId ) {
            $site   = $this->container->get( 'vs_application.repository.site' )->find( $this->siteId );
        }
        
        $repo               = $this->container->get( 'vs_application.repository.settings' );
        $settings           = $repo->getSettings( $site );
        $maintenanceMode    = false;
        $maintenancePage    = false;
        $debug              = false;
        
        if( isset( $settings ) ) {
            $maintenanceMode    = $settings->getMaintenanceMode();
            $maintenancePage    = $settings->getMaintenancePage();
            
            // This will detect if we are in dev environment
            $debug              = in_array( $this->container->get('kernel')->getEnvironment(), ['dev'] );
        }
        
        // If maintenance is active and in prod environment and user is not admin
        if ( $maintenanceMode ) {
            // Use this for DEBUG
            // if( true ) {
            if (
                ( ! $this->user || ! $this->user->hasRole( 'ROLE_ADMIN' ) )
                && ! $debug
            ) {
                $event->setResponse( new Response( $maintenancePage->getText(), 503 ) );
                
                $event->stopPropagation();
            } else {
                Alerts::$WARNINGS[]   = 'The System is in Maintenance Mode !';
            }   
        }
    }
}
