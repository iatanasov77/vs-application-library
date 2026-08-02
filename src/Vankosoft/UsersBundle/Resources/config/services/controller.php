<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\UsersBundle\Controller\ForgotPasswordController;
use Vankosoft\UsersBundle\Controller\ProfileController;
use Vankosoft\UsersBundle\Controller\UsersRolesExtController;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( ForgotPasswordController::class )
        ->args([
            service( 'doctrine' ),
            service( 'vs_users.repository.reset_password_request' ),
            service( 'vs_users.repository.users' ),
            service( 'mailer' ),
            service( 'vs_users.factory.reset_password_request' ),
            service( 'vs_users.manager.user' ),
            [
                'defaultRedirect' => param( 'vs_users.default_redirect' ),
                'mailerUser' => param( 'vs_application.mailer_user' ),
            ],
        ])
        ->call( 'setResetPasswordHelper', [service( 'symfonycasts.reset_password.helper' )] )
        ->tag( 'controller.service_arguments' );
    
    $services->set( ProfileController::class )
        ->args([
            service( 'doctrine' ),
            param( 'vs_users.model.users.class' ),
            service( 'vs_users.manager.user' ),
            service( 'vs_users.factory.avatar_image' ),
            service( 'vs_cms.profile_uploader' ),
            service( 'vs_agent.agent' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( UsersRolesExtController::class )
        ->args([
            service( 'translator' ),
            service( 'vs_users.repository.users' ),
            service( 'vs_users.repository.user_roles' ),
            service( 'vs_application.repository.taxonomy' ),
            service( 'vs_application.repository.taxon' ),
        ])
        ->tag( 'controller.service_arguments' );
};
