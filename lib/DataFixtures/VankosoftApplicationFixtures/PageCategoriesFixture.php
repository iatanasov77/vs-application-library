<?php namespace VS\ApplicationBundle\DataFixtures\VankosoftApplicationFixtures;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use VS\ApplicationBundle\DataFixtures\AbstractResourceFixture;

final class PageCategoriesFixture extends AbstractResourceFixture
{
    public function getName(): string
    {
        return 'page_categories';
    }
    
    protected function configureResourceNode( ArrayNodeDefinition $resourceNode ): void
    {
        $resourceNode
            ->children()
                ->scalarNode( 'locale' )->end()
                ->scalarNode( 'title' )->end()
                ->scalarNode( 'taxonomy_title' )->end()
                ->scalarNode( 'taxonomy_description' )->end()
        ;
    }
}
