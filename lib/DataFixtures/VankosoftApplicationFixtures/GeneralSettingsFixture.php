<?php namespace VS\ApplicationBundle\DataFixtures\VankosoftApplicationFixtures;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use VS\ApplicationBundle\DataFixtures\AbstractResourceFixture;

final class GeneralSettingsFixture extends AbstractResourceFixture
{
    public function getName(): string
    {
        return 'general_settings';
    }
    
    protected function configureResourceNode( ArrayNodeDefinition $resourceNode ): void
    {
        $resourceNode
            ->children()
                ->booleanNode( 'maintenanceMode' )->cannotBeEmpty()->end()
                ->scalarNode( 'theme' )->end()
                
                ->scalarNode( 'site' )->end()
                ->scalarNode( 'maintenancePage' )->end()
        ;
    }
}
