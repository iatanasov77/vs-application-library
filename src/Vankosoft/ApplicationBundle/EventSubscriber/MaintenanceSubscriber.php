<?php namespace Vankosoft\ApplicationBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment as TwigEnvironment;

/**
 * This is the New Class which should to be used for Maintenance Mode
 */
class MaintenanceSubscriber implements EventSubscriberInterface
{
    /** @var TwigEnvironment */
    private TwigEnvironment $twig;
    
    public function __construct( TwigEnvironment $twig )
    {
        $this->twig = $twig;
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['onMaintenance', \PHP_INT_MAX - 1000],
            ],
        ];
    }
    
    public function onMaintenance( RequestEvent $event ): void
    {
        /** @var bool $isMaintenance */
        $isMaintenance = \filter_var( $_ENV['MAINTENANCE_MODE'] ?? '0', \FILTER_VALIDATE_BOOLEAN );
        
        if ( $isMaintenance ) {
            $event->setResponse( new Response(
                $this->twig->render( 'maintenance.html.twig' ),
                Response::HTTP_SERVICE_UNAVAILABLE,
            ));
            $event->stopPropagation();
        }
    }
}
