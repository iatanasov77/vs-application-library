<?php namespace Vankosoft\ApplicationInstalatorBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Exception\RuntimeException;

#[AsCommand(
    name: 'vankosoft:install:project-version',
    description: 'Installs VankoSoft Project Version.',
    hidden: false
)]
final class InstallProjectVersionCommand extends AbstractInstallCommand
{
    protected function configure(): void
    {
        $this
            ->setHelp(<<<EOT
The <info>%command.name%</info> command installs a Project Version and run doctrine migration for this version.
EOT
            )
            ->addOption( 'debug-commands', 'd', InputOption::VALUE_OPTIONAL, 'Debug Executed Commands', null )
            ->addOption( 'app-config-fixture-suite', 'c', InputOption::VALUE_OPTIONAL, 'Load specified fixture suite during install', null )
            ->addOption( 'sample-data-fixture-suite', 's', InputOption::VALUE_OPTIONAL, 'Load specified fixture suite during install', null )
        ;
    }
    
    protected function execute( InputInterface $input, OutputInterface $output ): int
    {
        $bufferedOutput = new BufferedOutput();
        $this->commandExecutor->runCommand( 'vankosoft:install:info', [], $bufferedOutput );
        
        echo $bufferedOutput->fetch();
        
        return Command::SUCCESS;
    }
}
