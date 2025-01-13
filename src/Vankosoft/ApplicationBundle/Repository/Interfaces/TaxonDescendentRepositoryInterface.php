<?php namespace Vankosoft\ApplicationBundle\Repository\Interfaces;

use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Vankosoft\ApplicationBundle\Model\Interfaces\TaxonDescendentInterface;

interface TaxonDescendentRepositoryInterface extends RepositoryInterface
{
    public function findByTaxonId( $taxonId );
    public function findByTaxonCode( $code );
    public function getPathAsString( TaxonDescendentInterface $category ): string;
    public function getPathAsPath( TaxonDescendentInterface $category ): string;
    public function findByPath( string $path ): TaxonDescendentInterface;
}