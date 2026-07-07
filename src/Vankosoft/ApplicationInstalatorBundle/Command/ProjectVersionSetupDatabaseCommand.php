<?php namespace Vankosoft\ApplicationInstalatorBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\RuntimeException;
use Vankosoft\ApplicationInstalatorBundle\Model\InstalationInfoInterface;

#[AsCommand(
    name: 'vankosoft:project-version:setup-database',
    description: 'Installs VankoSoft Project Version.',
    hidden: false
)]
final class ProjectVersionSetupDatabaseCommand extends ProjectVersionAbstractCommand
{
    protected function configure(): void
    {
        $this
            ->setHelp(<<<EOT
The <info>%command.name%</info> command installs a Project Version and run doctrine migration for this version.
EOT
            )
        ;
    }
    
    protected function execute( InputInterface $input, OutputInterface $output ): int
    {
        $style          = new SymfonyStyle( $input, $output );
        $installInfo    = $this->getInstallInfo();
        
        $migrationOutput = $this->runDoctrineMigration( $installInfo );
        $style->success( \ltrim( $migrationOutput, '[OK] ') );
        $style->newLine();
        
        $this->updateInstallInfo( $installInfo );
        $style->success( 'Successfully updated Install Info !!!' );
        $style->newLine();
        
        return Command::SUCCESS;
    }
    
    private function runDoctrineMigration( ?array $installInfo )
    {
        $doctrineMigration = null;
        if ( $installInfo ) {
            $doctrineMigration = $installInfo[InstalationInfoInterface::VERSION_DATA_DOCTRINE_MIGRATION];
        }
        
        if ( ! $doctrineMigration ) {
            $bufferedOutputVersion = new BufferedOutput();
            $this->commandExecutor->runCommand( 'doctrine:migrations:latest', [], $bufferedOutputVersion );
            $doctrineMigration = $bufferedOutputVersion->fetch();
        }
        
        $bufferedOutputMigration = new BufferedOutput();
        $options = [
            'version' => \trim( $doctrineMigration ),
            '--no-interaction' => true,
            '--all-or-nothing' => true,
        ];
        $this->commandExecutor->runCommand( 'doctrine:migrations:migrate', $options, $bufferedOutputMigration );
        
        return $bufferedOutputMigration->fetch();
    }
    
    private function updateInstallInfo( ?array $installInfo )
    {
        $process = new Process([
            '/usr/bin/git',
            'describe',
            '--abbrev=0'
        ]);
        $process->setWorkingDirectory( $this->projectRootPath );
        $process->run();
        $latestVersion = $process->getOutput();
        $latestVersion = \trim( $latestVersion );
        
        $installInfoVersion = 'v' . \trim( $installInfo[InstalationInfoInterface::VERSION_DATA_PROJECT_VERSION] );
        if ( $installInfoVersion !== $latestVersion ) {
            $this->commandExecutor->runCommand( 'vankosoft:install:info', ['action' => 'update'] );
        }
    }
}
