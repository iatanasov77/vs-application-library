<?php namespace VS\ApplicationBundle\DataFixtures\Factory;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Component\Resource\Factory\FactoryInterface;
use VS\ApplicationBundle\Model\Interfaces\SettingsInterface;

use VS\ApplicationBundle\Model\Interfaces\SiteInterface;
use VS\CmsBundle\Model\PageInterface;

class GeneralSettingsExampleFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    /** @var FactoryInterface */
    private $settingsFactory;
    
    /** @var OptionsResolver */
    private $optionsResolver;
    
    public function __construct( FactoryInterface $settingsFactory )
    {
        $this->settingsFactory = $settingsFactory;
        $this->optionsResolver = new OptionsResolver();
        
        $this->configureOptions( $this->optionsResolver );
    }
    
    public function create( array $options = [] ): SettingsInterface
    {
        $options    = $this->optionsResolver->resolve( $options );
        
        $settingsEntity = $this->settingsFactory->createNew();
        
        $settingsEntity->setSite( $options['site'] );
        $settingsEntity->setMaintenanceMode( $options['maintenanceMode'] );
        $settingsEntity->setMaintenancePage( $options['maintenancePage'] );
        $settingsEntity->setTheme( $options['theme'] );
        
        return $settingsEntity;
    }
    
    protected function configureOptions( OptionsResolver $resolver ): void
    {
        $resolver
            ->setDefault( 'site', null )
            ->setAllowedTypes( 'site', ['null', SiteInterface::class] )
            
            ->setDefault( 'maintenanceMode', false )
            ->setAllowedTypes( 'maintenanceMode', 'bool' )
            
            ->setDefault( 'maintenancePage', null )
            ->setAllowedTypes( 'maintenancePage', ['null', PageInterface::class] )
            
            ->setDefault( 'theme', null )
            ->setAllowedTypes( 'theme', ['null', 'string'] )
        ;
    }
    
}
