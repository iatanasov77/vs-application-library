<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationBundle\Controller\SettingsController;
use Vankosoft\ApplicationBundle\Controller\AuthController;
use Vankosoft\ApplicationBundle\Controller\AboutController;
use Vankosoft\ApplicationBundle\Controller\DashboardController;
use Vankosoft\ApplicationBundle\Controller\ApplicationExtController;
use Vankosoft\ApplicationBundle\Controller\SettingsExtController;
use Vankosoft\ApplicationBundle\Controller\TaxonomyTaxonsController;
use Vankosoft\ApplicationBundle\Controller\PasswordGeneratorController;
use Vankosoft\ApplicationBundle\Controller\ContactController;
use Vankosoft\ApplicationBundle\Controller\CookieConsentTranslationsExtController;
use Vankosoft\ApplicationBundle\Controller\TagsWhitelistContextsExtController;
use Vankosoft\ApplicationBundle\Controller\BannersRotatorController;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    $parameters = $container->parameters();
    
    $parameters
        ->set( 'vs_application.contact_email', 'env(resolve:CONTACT_EMAIL)' )
        ->set( 'vs_application.contact.show_map', true )
        ->set( 'vs_application.contact.show_address', true )
        ->set( 'vs_application.contact.show_phone', true )
        ->set( 'vs_application.contact.google_map', 'https://maps.google.co.uk/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=18+California,+Fresno,+CA,+United+States&amp;aq=0&amp;oq=18+California+united+state&amp;sll=39.9589,-120.955336&amp;sspn=0.007114,0.016512&amp;ie=UTF8&amp;hq=&amp;hnear=18,+Fresno,+California+93727,+United+States&amp;t=m&amp;ll=36.732762,-119.695787&amp;spn=0.017197,0.100336&amp;z=14&amp;output=embed' )
        ->set( 'vs_application.contact.google_large_map', 'https://maps.google.co.uk/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=18+California,+Fresno,+CA,+United+States&amp;aq=0&amp;oq=18+California+united+state&amp;sll=39.9589,-120.955336&amp;sspn=0.007114,0.016512&amp;ie=UTF8&amp;hq=&amp;hnear=18,+Fresno,+California+93727,+United+States&amp;t=m&amp;ll=36.732762,-119.695787&amp;spn=0.017197,0.100336&amp;z=14' )
    ;
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( SettingsController::class )
        ->tag( 'controller.service_arguments' );
    
    $services->set( AuthController::class )
        ->args([
            service( 'vs_users.security_bridge' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( AboutController::class )
        ->args([
            service( 'vs_application.version_info' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( DashboardController::class )
        ->tag( 'controller.service_arguments' );
    
    $services->set( ApplicationExtController::class )
        ->args([
            service( 'doctrine' ),
            service( 'vs_application.repository.application' ),
            service( 'vs_application.factory.application' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( SettingsExtController::class )
        ->args([
            service( 'doctrine' ),
            service( 'vs_app.settings_manager' ),
            service( 'vs_application.repository.application' ),
            service( 'vs_application.repository.settings' ),
            service( 'vs_application.factory.settings' ),
            service( 'vs_application.repository.taxonomy' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( TaxonomyTaxonsController::class )
        ->args([
            service( 'doctrine' ),
            service( 'vs_application.repository.taxonomy' ),
            service( 'vs_application.repository.taxon' ),
            service( 'vs_application.slug_generator' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( PasswordGeneratorController::class )
        ->args([
            service( 'hackzilla.password_generator.computer' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( ContactController::class )
        ->args([
            [
                'applicationTitle'  => '%applicationTitle%',
                'contactEmail'      => '%vs_application.contact_email%',
                'showAddress'       => '%vs_application.contact.show_address%',
                'showPhone'         => '%vs_application.contact.show_phone%',
                'showMap'           => '%vs_application.contact.show_map%',
                'googleMap'         => '%vs_application.contact.google_map%',
                'googleLargeMap'    => '%vs_application.contact.google_large_map%'
            ],
            service( 'mailer' ),
            service( 'vs_users.notifications' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( CookieConsentTranslationsExtController::class )
        ->args([
            service( 'vs_application.doctrine_dbal_cache' ),
            service( 'vs_application.repository.cookie_consent_translation' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( TagsWhitelistContextsExtController::class )
        ->args([
            service( 'doctrine' ),
            service( 'vs_application.repository.tags_whitelist_context' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( BannersRotatorController::class )
        ->args([
            service( 'vs_cms.repository.banner_place' ),
            service( 'liip_imagine.cache.manager' ),
        ])
        ->tag( 'controller.service_arguments' );
};
