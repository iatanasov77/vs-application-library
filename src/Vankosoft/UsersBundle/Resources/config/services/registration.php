<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\UsersBundle\Controller\RegisterController;
use Vankosoft\UsersBundle\Form\RegistrationFormType;
use Vankosoft\UsersBundle\Form\ProfileFormType;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    $parameters = $container->parameters();
    
    $parameters
        ->set( 'vs_users.registration_form', RegistrationFormType::class )
        ->set( 'vs_users.register_role', 'role-application-admin' )
        ->set( 'vs_users.login_after_verify', true )
        
        ->set( 'vs_users.registration_form_required_fields', [] )
        ->set( 'vs_users.profile_form_required_fields', [] )
    ;
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( 'vs_users.registration_controller', RegisterController::class )
        ->tag( 'controller.service_arguments' )
        ->args([
            service( 'doctrine' ),
            service( 'translator' ),
            service( 'vs_application.context.application' ),
            service( 'vs_users.manager.user' ),
            service( 'vs_users.repository.users' ),
            service( 'vs_users.factory.users' ),
            service( 'vs_users.repository.user_roles' ),
            service( 'mailer' ),
            service( 'vs_cms.repository.pages' ),
            service( 'security.user_authenticator' ),
            service( 'vs_users.security.another_login_form_authenticator' ),
            [
                'registrationForm' => param( 'vs_users.registration_form' ),
                'registerRole' => param( 'vs_users.register_role' ),
                'defaultRedirect' => param( 'vs_users.default_redirect' ),
                'mailerUser' => param( 'vs_application.mailer_user' ),
                'loginAfterVerify' => param( 'vs_users.login_after_verify' ),
            ],
        ])
        ->call( 'setContainer', [service( 'service_container' )] )
        ->call( 'setTokenGenerator', [service( 'symfonycasts.verify_email.token_generator' )] )
        ->call( 'setVerifyEmailHelper', [service( 'symfonycasts.verify_email.helper' )] );
    
    $services->set( 'vs_users.form.type.profile', ProfileFormType::class )
        ->tag( 'form.type', ['alias' => 'vs_users_profile'] )
        ->args([
            param( 'vs_users.model.users.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
            param( 'vs_application.model.application.class' ),
            param( 'vs_users.model.user_roles.class' ),
            service( 'security.helper' ),
            param( 'vs_users.profile_form_required_fields' ),
        ]);
    
    $services->set( 'vs_users.form.type.registration', RegistrationFormType::class )
        ->tag( 'form.type', ['alias' => 'vs_users_registration'] )
        ->args([
            param( 'vs_users.model.users.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
            param( 'vs_application.model.application.class' ),
            param( 'vs_users.model.user_roles.class' ),
            service( 'security.helper' ),
            param( 'vs_users.registration_form_required_fields' ),
        ]);
};
