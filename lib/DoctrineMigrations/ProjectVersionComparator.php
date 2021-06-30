<?php namespace VS\ApplicationBundle\DoctrineMigrations;

use Doctrine\Migrations\Version\Comparator;
use Doctrine\Migrations\Version\AlphabeticalComparator;
use Doctrine\Migrations\Version\Version;
use MJS\TopSort\Implementations\ArraySort;

class ProjectVersionComparator implements Comparator
{
    private $dependencies;
    private $defaultSorter;
    
    public function __construct()
    {
        $this->defaultSorter    = new AlphabeticalComparator();
        $this->dependencies     = $this->buildDependencies();
    }
    
    private function buildDependencies(): array
    {
        $sorter = new ArraySort();
        
        $sorter->add( 'VS\ApplicationBundle\DoctrineMigrations' );
        $sorter->add( 'App\DoctrineMigrations', ['VS\ApplicationBundle\DoctrineMigrations'] );
        
        return array_flip( $sorter->sort() );
    }
    
    private function getNamespacePrefix( Version $version ): string
    {
        $versionParts   = explode( '\\', $version );
        array_pop( $versionParts );
        $namespacePrefix    = implode( '\\', $versionParts );
        
        return $namespacePrefix;
    }
    
    public function compare( Version $a, Version $b ): int
    {
        $prefixA = $this->getNamespacePrefix( $a );
        $prefixB = $this->getNamespacePrefix( $b );
        
        return $this->dependencies[$prefixA] <=> $this->dependencies[$prefixB]
                ?: $this->defaultSorter->compare( $a, $b );
    }
}
