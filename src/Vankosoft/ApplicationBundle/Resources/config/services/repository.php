<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationBundle\Repository\TaxonRepository;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    $parameters = $container->parameters();
    
    $parameters
        ->set( 'vs_application.taxon_repository_throw_exception', false )
    ;
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services->set( 'vs_application.repository.taxon', TaxonRepository::class )
        ->factory( [service( 'doctrine.orm.entity_manager' ), 'getRepository'] )
        ->args([
            param( 'vs_application.model.taxon.class' ),
        ])
        ->call( 'setRootDir', [param( 'kernel.project_dir' )] )
        ->call( 'throwException', [param( 'vs_application.taxon_repository_throw_exception' )] );
};
