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
        // This will detect if we are in dev environment
        $debug              = in_array( $this->container->get('kernel')->getEnvironment(), ['dev'] );
        $settings           = $this->getSettingsManager()->getSettings( $this->siteId );
        
        // If maintenance is active and in prod environment and user is not admin
        if ( $settings['maintenanceMode'] ) {
            $maintenancePage    = $settings['maintenancePage'] ?
                                    $this->getPagesRepository()->find( $settings['maintenancePage'] ) :
                                    null;
            
            if (
                ( ! is_object( $this->user ) || ! $this->user->hasRole( 'ROLE_ADMIN' ) )
                && ! $debug
            ) {
                if ( $maintenancePage ) {
                    $event->setResponse( new Response( $maintenancePage->getText(), 503 ) );
                } else {
                    $event->setResponse( new Response( 'The System is in Maintenance Mode !', 503 ) );
                }
                
                $event->stopPropagation();
            } else {
                Alerts::$WARNINGS[]   = 'The System is in Maintenance Mode !';
            }   
        }
    }
    
    protected function getSettingsManager()
    {
        return $this->container->get( 'vs_app.settings_manager' );
    }
    
    protected function getPagesRepository()
    {
        return $this->container->get( 'vs_cms.repository.pages' );
    }
}
