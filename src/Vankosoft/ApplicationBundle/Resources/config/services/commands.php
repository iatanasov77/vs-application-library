<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationBundle\Command\RegenerateSlugsCommand;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->set( 'vs_application.command.regenerate_slugs', RegenerateSlugsCommand::class )
        ->tag( 'console.command' );
};
