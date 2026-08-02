<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Security\Http\Event\LogoutEvent;
use Vankosoft\UsersBundle\Security\SecurityBridge;
use Vankosoft\UsersBundle\Security\UserManager;
use Vankosoft\UsersBundle\Security\ActivityListener;
use Vankosoft\UsersBundle\Security\MainLogoutListener;
use Vankosoft\UsersBundle\Security\Firewall\AccessDeniedListener;
use Vankosoft\UsersBundle\Security\LoginFormAuthenticator;
use Vankosoft\UsersBundle\Security\AnotherLoginFormAuthenticator;
use Vankosoft\UsersBundle\Security\SuperAdminAccessTokenAuthenticator;
use Vankosoft\UsersBundle\Security\Voter\ApplicationVoter;
use Vankosoft\UsersBundle\Security\Voter\CrudDisabledModelsVoter;
use Vankosoft\UsersBundle\Security\Voter\CrudOwnerModelsVoter;
use Vankosoft\UsersBundle\Security\Voter\RequestVoter;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    $parameters = $container->parameters();
    
    $parameters
        ->set( 'vs_users.login_route', 'vs_application_login' )
        ->set( 'vs_users.login_by', 'email' )
        ->set( 'vs_users.default_redirect', 'vs_application_dashboard' )
        ->set( 'vs_users.redirect_after_verify', 'vs_users_profile_show' )
        
        // Commented Because is not Overrided with Project
        //->set( 'vs_users.form_create_account', true )
        
        ->set( 'vs_users.gc_maxlifetime', 1800 ) // 30 minutes
        ->set( 'vs_users.cookie.domain', param( 'env(COOKIE_DOMAIN)' ) )
        ->set( 'vs_users.cookie.lifetime', 86400 ) // 24 hours
        
        ->set( 'vs_users.voter.crud_disabled_models', [] )
        ->set( 'vs_users.voter.crud_owner_models', [] )
    ;
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( 'vs_users.security_bridge', SecurityBridge::class )
        ->args([
            service( 'security.token_storage' ),
        ]);
    
    $services->set( 'vs_users.manager.user', UserManager::class )
        ->args([
            service( 'vs_users.factory.users' ),
            service( 'vs_users.repository.users' ),
            service( 'doctrine.orm.entity_manager' ),
            service( 'security.password_hasher_factory' ),
            service( 'vs_users.factory.user_info' ),
            service( 'vs_users.factory.avatar_image' ),
            service( 'vs_cms.profile_uploader' ),
        ]);
    
    $services->set( 'vs_users.security.activity_listener', ActivityListener::class )
        ->args([
            service( 'vs_users.security_bridge' ),
            service( 'doctrine.orm.entity_manager' ),
        ])
        ->tag( 'kernel.event_listener', ['event' => 'kernel.controller', 'method' => 'onCoreController'] );
    
    $services->set( 'vs_users.security.logout_success_handler', MainLogoutListener::class )
        ->args([
            service( 'security.http_utils' ),
            '/',
        ])
        ->tag( 'kernel.event_listener', ['event' => LogoutEvent::class, 'dispatcher' => 'security.event_dispatcher.main'] );
    
    $services->set( 'vs_users.security.firewall.access_denied_listener', AccessDeniedListener::class )
        ->args([
            service( 'router' ),
            ['loginRoute' => param( 'vs_users.login_route' ),],
            
        ])
        ->tag( 'kernel.event_listener', ['event' => 'kernel.exception', 'method' => 'onKernelException'] );
    
    /**
     * Authenticators
     */
    $services->set( 'vs_users.security.login_form_authenticator', LoginFormAuthenticator::class )
        ->args([
            service( 'router' ),
            service( 'security.csrf.token_manager' ),
            service( 'security.password_hasher_factory' ),
            service( 'vs_users.repository.users' ),
            service( 'doctrine.orm.entity_manager' ),
            service( 'translator' ),
            service( 'symfonycasts.reset_password.random_generator' ),
            [
                'loginRoute' => param( 'vs_users.login_route' ),
                'loginBy' => param( 'vs_users.login_by' ),
                'defaultRedirect' => param( 'vs_users.default_redirect' ),
            ],
        ]);
    
    $services->set( 'vs_users.security.another_login_form_authenticator', AnotherLoginFormAuthenticator::class )
        ->args([
            service( 'router' ),
            service( 'security.csrf.token_manager' ),
            service( 'security.password_hasher_factory' ),
            service( 'vs_users.repository.users' ),
            [
                'loginRoute' => param( 'vs_users.login_route' ),
                'redirectAfterLogin' => param( 'vs_users.redirect_after_verify' ),
            ],
        ]);
    
    $services->set( 'vs_users.security.super_admin_access_token_authenticator', SuperAdminAccessTokenAuthenticator::class )
        ->args([
            service( 'doctrine' ),
            service( 'vs_users.manager.user' ),
            service( 'vs_users.repository.users' ),
            service( 'vs_users.factory.users' ),
            service( 'vs_users.repository.user_roles' ),
        ]);
    
    /**
     * Voters
     */
    $services->set( 'vs_users.security.application_voter', ApplicationVoter::class )
        ->args([
            service( 'vs_application.context.application' ),
        ])
        ->tag( 'security.voter' );
    
    $services->set( 'vs_users.security.voter.crud_disabled_models', CrudDisabledModelsVoter::class )
        ->args([
            service( 'vs_application.context.application' ),
            param( 'vs_users.voter.crud_disabled_models' ),
            service( 'service_container' ),
        ])
        ->tag( 'security.voter' );
    
    $services->set( 'vs_users.security.voter.crud_owner_models', CrudOwnerModelsVoter::class )
        ->args([
            service( 'vs_application.context.application' ),
            param( 'vs_users.voter.crud_owner_models' ),
            service( 'service_container' ),
        ])
        ->tag( 'security.voter' );
    
    $services->set( 'vs_users.security.request_voter', RequestVoter::class )
        ->args([
            service( 'vs_application.context.application' ),
            service( 'security.helper' ),
            service( 'security.role_hierarchy' ),
        ])
        ->tag( 'security.voter' );
};
