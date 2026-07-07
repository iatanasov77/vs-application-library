<?php namespace Vankosoft\ApplicationInstalatorBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\RuntimeException;

use Vankosoft\ApplicationInstalatorBundle\Model\InstalationInfoInterface;

#[AsCommand(
    name: 'vankosoft:project-version:setup-dependencies',
    description: 'Setup VankoSoft Project Version Dependencies .',
    hidden: false
)]
class ProjectVersionSetupDependenciesCommand extends ProjectVersionAbstractCommand
{
    protected function configure(): void
    {
        $this
            ->setHelp(<<<EOT
The <info>%command.name%</info> command installs a Project Version and setup dependencies for this version.
EOT
            )
        ;
    }
    
    protected function execute( InputInterface $input, OutputInterface $output ): int
    {
        $installInfo        = $this->getInstallInfo();
        
        $composerOutput = $this->useVankosoftApplicationCoreVersion( $installInfo );
        //var_dump( $composerOutput );
        
        return Command::SUCCESS;
    }
    
    private function useVankosoftApplicationCoreVersion( ?array $installInfo )
    {
        if ( $installInfo ) {
            $coreVersion = $installInfo[InstalationInfoInterface::VERSION_DATA_VANKOSOFT_APPLICATION_VERSION];
            
            $process = new Process([
                '/usr/local/bin/composer',
                'update',
                'vankosoft/application:' . \trim( \ltrim( $coreVersion, 'v' ) ),
                '--no-interaction'
            ]);
            $process->setWorkingDirectory( $this->projectRootPath );
            $process->run( null, [
                'COMPOSER_HOME' => '/home/vagrant/.composer',
                'COMPOSER_ALLOW_SUPERUSER' => 1,
                'COMPOSER_PROCESS_TIMEOUT' => 600,
            ]);
            
            return $process->getOutput();
        }
        
        return null;
    }
}
