<?php namespace VS\ApplicationBundle\DataFixtures\Factory;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Component\Resource\Factory\FactoryInterface;

use Sylius\Component\Locale\Model\LocaleInterface;

class LocalesExampleFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    /** @var FactoryInterface */
    private $localesFactory;
    
    /** @var OptionsResolver */
    private $optionsResolver;
    
    public function __construct(
        FactoryInterface $localesFactory
    ) {
            $this->localesFactory   = $localesFactory;
            
            $this->optionsResolver  = new OptionsResolver();
            $this->configureOptions( $this->optionsResolver );
    }
    
    public function create( array $options = [] ): LocaleInterface
    {
        $options    = $this->optionsResolver->resolve( $options );
        
        $localeEntity = $this->localesFactory->createNew();
        
        $localeEntity->setCode( $options['code'] );
        
        return $localeEntity;
    }
    
    protected function configureOptions( OptionsResolver $resolver ): void
    {
        $resolver            
            ->setDefault( 'code', null )
            ->setAllowedTypes( 'code', ['string'] )
        ;
    }
}
