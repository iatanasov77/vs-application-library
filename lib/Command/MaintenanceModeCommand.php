<?php namespace VS\ApplicationBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MaintenanceModeCommand extends Command
{    
    protected static $defaultName = 'vs:maintenance';
    
    private $container;
    
    public function __construct( ContainerInterface $container )
    {
        parent::__construct();
        $this->container    = $container;
    }
    
    protected function configure()
    {
        $this
            ->setDescription( 'Manage Maintenance Mode with CLI. Use it in deployment scrpipts for example.' )
            ->setHelp( 'Manage Maintenance Mode with CLI.' )
            
            ->addOption( 'set-maintenance', null, InputOption::VALUE_NONE, 'Set In Maintennce Mode.')
            ->addOption( 'unset-maintenance', null, InputOption::VALUE_NONE, 'Unset Maintennce Mode.')
        ;
    }
    
    protected function execute( InputInterface $input, OutputInterface $output )
    {
        $io = new SymfonyStyle( $input, $output );
        $io->newLine();
        
        if ( $input->getOption( 'set-maintenance' ) ) {
            $this->container->get( 'vs_app.settings_manager' )->forceMaintenanceMode( true );
        }
        
        if ( $input->getOption( 'unset-maintenance' ) ) {
            $this->container->get( 'vs_app.settings_manager' )->forceMaintenanceMode( false );
        }
        
        return 0;
    }
}
