<?php namespace VS\ApplicationBundle\DataFixtures\Factory;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Component\Resource\Factory\FactoryInterface;
use VS\ApplicationBundle\Model\Interfaces\SettingsInterface;

use VS\ApplicationBundle\Model\Interfaces\SiteInterface;
use VS\CmsBundle\Model\PageInterface;

class PageCategoriesExampleFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    /** @var FactoryInterface */
    private $taxonomyFactory;
    
    /** @var FactoryInterface */
    private $taxonFactory;
    
    /** @var FactoryInterface */
    private $pageCategoriesFactory;
    
    /** @var OptionsResolver */
    private $optionsResolver;
    
    public function __construct(
        FactoryInterface $taxonomyFactory,
        FactoryInterface $taxonFactory,
        FactoryInterface $pageCategoriesFactory
    ) {
        $this->taxonomyFactory          = $taxonomyFactory;
        $this->taxonFactory             = $taxonFactory;
        $this->pageCategoriesFactory    = $pageCategoriesFactory;
        
        $this->optionsResolver          = new OptionsResolver();
        
        $this->configureOptions( $this->optionsResolver );
    }
    
    public function create( array $options = [] ): SettingsInterface
    {
        $options    = $this->optionsResolver->resolve( $options );
        
        $taxonomyEntity             = $this->taxonomyFactory->createNew();
        $taxonomyRootTaxonEntity    = $this->taxonFactory->createNew();
        $taxonEntity                = $this->taxonFactory->createNew();
        $pageCategoryEntity         = $this->pageCategoriesFactory->createNew();
        
        $taxonomyRootTaxonEntity->setCurrentLocale( $options['locale'] );
        $taxonomyRootTaxonEntity->getTranslation()->setName( 'Root taxon of Taxonomy: "' . $options['taxonomy_title'] );
        $taxonomyRootTaxonEntity->getTranslation()->setDescription( 'Root taxon of Taxonomy: "' . $options['taxonomy_title'] . '"' );
        $taxonomyRootTaxonEntity->getTranslation()->setSlug( Slug::generate( $options['taxonomy_title'] ) );
        $taxonomyRootTaxonEntity->getTranslation()->setTranslatable( $taxonomyRootTaxonEntity );
        
        $taxonomyEntity->setName( $options['taxonomy_title'] );
        $taxonomyEntity->setDescription( $options['taxonomy_description'] );
        $taxonomyEntity->setRootTaxon( $taxonomyRootTaxonEntity );
        
        $taxonEntity->setTitle( $options['title'] );
        $pageCategoryEntity->setTaxon( $taxonEntity );
        
        return $pageCategoryEntity;
    }
    
    protected function configureOptions( OptionsResolver $resolver ): void
    {
        $resolver
            ->setDefault( 'title', null )
            ->setAllowedTypes( 'title', ['string'] )
        ;
    }
    
}
