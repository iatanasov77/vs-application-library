<?php namespace VS\ApplicationBundle\DataFixtures\Factory;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Component\Resource\Factory\FactoryInterface;
use VS\ApplicationBundle\Model\Interfaces\SettingsInterface;

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
        
        /** @var AdminUserInterface $user */
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
            ->setAllowedTypes( 'site', 'int' )
            
            ->setDefault( 'maintenanceMode', 0 )
            ->setAllowedTypes( 'maintenanceMode', 'int' )
            
            ->setDefault( 'maintenancePage', null )
            ->setAllowedTypes( 'maintenancePage', 'int' )
            
            ->setDefault( 'theme', null )
            ->setAllowedTypes( 'theme', 'string' )
        ;
    }
    
}
