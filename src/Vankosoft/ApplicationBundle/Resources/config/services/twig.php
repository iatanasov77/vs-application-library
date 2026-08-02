<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationBundle\Twig\ReadableFilesizeExtension;
use Vankosoft\ApplicationBundle\Twig\VsTagsExtension;
use Vankosoft\ApplicationBundle\Twig\FunctionsExtension;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->set( ReadableFilesizeExtension::class )
        ->tag( 'twig.extension' );
    
    $services->set( VsTagsExtension::class )
        ->tag( 'twig.extension' );
    
    $services->set( FunctionsExtension::class )
        ->args([
            service( 'parameter_bag' ),
        ])
        ->tag( 'twig.extension' );
};
