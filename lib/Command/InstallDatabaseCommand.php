<?php namespace VS\ApplicationBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class InstallDatabaseCommand extends AbstractInstallCommand
{
    protected static $defaultName = 'vankosoft:install:database';

    protected function configure(): void
    {
        $this
            ->setDescription( 'Install VankoSoft Application database.' )
            ->setHelp(<<<EOT
The <info>%command.name%</info> command creates VankoSoft Application database.
EOT
            )
            ->addOption( 'fixture-suite', 's', InputOption::VALUE_OPTIONAL, 'Load specified fixture suite during install', null )
        ;
    }

    protected function execute( InputInterface $input, OutputInterface $output ): int
    {
        $suite = $input->getOption( 'fixture-suite' );

        $outputStyle    = new SymfonyStyle( $input, $output );
        $outputStyle->writeln( sprintf(
            'Creating VankoSoft Application database for environment <info>%s</info>.',
            $this->getEnvironment()
        ) );

        $commands = $this
            ->getContainer()
            ->get( 'vs_app.commands_provider.database_setup' )
            ->getCommands( $input, $output, $this->getHelper( 'question' ) )
        ;

        $this->runCommands( $commands, $output );
        $outputStyle->newLine();

        $parameters = [];
        if ( null !== $suite ) {
            $parameters['--fixture-suite'] = $suite;
        }
        $this->commandExecutor->runCommand( 'vankosoft:install:sample-data', $parameters, $output );

        return 0;
    }
}
