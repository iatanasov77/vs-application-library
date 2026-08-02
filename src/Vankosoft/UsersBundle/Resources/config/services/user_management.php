<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\UsersBundle\Repository\UsersRepository;
use Vankosoft\UsersBundle\Controller\UsersExtController;
use Vankosoft\UsersBundle\Form\UserFormType;
use Vankosoft\UsersBundle\Form\UserRoleForm;
use Vankosoft\UsersBundle\Command\CreateUserCommand;
use Vankosoft\UsersBundle\Command\ChangePasswordCommand;
use Vankosoft\UsersBundle\Command\RemoveBadUsersCommand;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    $parameters = $container->parameters();
    
    $parameters
        ->set( 'vs_users.crud.display_siblings', false )
        ->set( 'vs_users.users_form_required_fields', [] )
    ;
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( 'vs_users.repository.users', UsersRepository::class );

    $services->set( UsersExtController::class )
        ->tag( 'controller.service_arguments' )
        ->args([
            service( 'doctrine' ),
            service( 'vs_users.security_bridge' ),
            service( 'vs_users.repository.users' ),
            service( 'vs_users.factory.user_info' ),
            service( 'vs_users.factory.avatar_image' ),
            service( 'vs_cms.profile_uploader' ),
            service( 'vs_users.repository.user_roles' ),
            param( 'vs_users.crud.display_siblings' ),
        ])
        ->call( 'setContainer', [service( 'service_container' )] );
    
    $services->set( 'vs_users.resources.users.form', UserFormType::class )
        ->tag( 'form.type' )
        ->args([
            param( 'vs_users.model.users.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
            param( 'vs_application.model.application.class' ),
            param( 'vs_users.model.user_roles.class' ),
            service( 'security.helper' ),
            param( 'vs_users.users_form_required_fields' ),
        ]);
    
    $services->set( 'vs_users.resources.user_roles.form', UserRoleForm::class )
        ->tag( 'form.type' )
        ->args([
            param( 'vs_users.model.user_roles.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
            service( 'vs_users.repository.user_roles' ),
        ]);
    
    $services->set( 'vs_users.command.create_user', CreateUserCommand::class )
        ->tag( 'console.command' )
        ->args([
            service( 'vs_users.manager.user' ),
        ]);
    
    $services->set( 'vs_users.command.change_password', ChangePasswordCommand::class )
        ->tag( 'console.command' )
        ->args([
            service( 'vs_users.manager.user' ),
            service( 'vs_users.repository.users' ),
        ]);
    
    $services->set( 'vs_users.command.remove_bad_users', RemoveBadUsersCommand::class )
        ->tag( 'console.command' )
        ->args([
            service( 'doctrine' ),
            service( 'vs_users.repository.user_roles' ),
        ]);
};
