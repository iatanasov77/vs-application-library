<?php namespace VS\ApplicationBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;

final class ClearInstallCommand extends Command
{
    protected static $defaultName = 'vankosoft:clear-install';
    
    protected function configure(): void
    {
        $this
            ->setDescription( 'Clear VankoSoft Application Installation.' )
            ->setHelp(<<<EOT
The <info>%command.name%</info> command clear installation of VankoSoft Application.
EOT
            )
            ->addArgument( 'application', InputArgument::REQUIRED, 'The Application Name to be cleared.' )
        ;
    }
    
    protected function execute( InputInterface $input, OutputInterface $output ): int
    {
        $applicationName    = $input->getArgument( 'application' );
        $appSetup           = $this->getContainer()->get( 'vs_application.application.setup_application' );
        
        $outputStyle        = new SymfonyStyle( $input, $output );
        $outputStyle->writeln( '<info>Clear Installation of VankoSoft Application...</info>' );
        
        foreach ( $appSetup->getApplicationDirectories( $applicationName ) as $dir ) {
            exec( 'rm -rf ' . $dir );
        }
        
        $outputStyle->writeln( '<info>Application Directories successfully cleared.</info>' );
        $outputStyle->newLine();
        
        return 0;
    }
}
