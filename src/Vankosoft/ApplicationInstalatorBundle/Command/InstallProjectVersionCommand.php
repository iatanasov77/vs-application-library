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

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Container\ContainerInterface;

use Vankosoft\ApplicationInstalatorBundle\Model\InstalationInfoInterface;

#[AsCommand(
    name: 'vankosoft:install:project-version',
    description: 'Installs VankoSoft Project Version.',
    hidden: false
)]
final class InstallProjectVersionCommand extends AbstractInstallCommand
{
    /** @var string */
    private $projectRootPath;
    
    public function __construct(
        ContainerInterface $container,
        ManagerRegistry $doctrine,
        ValidatorInterface $validator,
        string $projectRootPath
    ) {
        parent::__construct( $container, $doctrine, $validator );
        
        $this->projectRootPath = $projectRootPath;
    }
    
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
        $installInfo        = $this->getInstallInfo();
        
        $composerOutput = $this->useVankosoftApplicationCoreVersion( $installInfo );
        var_dump( $composerOutput );
        
        $migrationOutput = $this->runDoctrineMigration( $installInfo );
        var_dump( $migrationOutput );
        
        $this->updateInstallInfo( $installInfo );
        
        return Command::SUCCESS;
    }
    
    private function getInstallInfo()
    {
        $bufferedOutput = new BufferedOutput();
        $this->commandExecutor->runCommand( 'vankosoft:install:info', ['json-info' => 'json-info'], $bufferedOutput );
        
        $jsonInfo = $bufferedOutput->fetch();
        $info = \json_decode( $jsonInfo, true );
        
        $versionInfo = $this->get( 'vs_application_instalator.repository.instalation_info' )->findOneBy([
            'version' => $info[InstalationInfoInterface::VERSION_DATA_PROJECT_VERSION]
        ]);
        
        return $versionInfo ? $info : null;
    }
    
    private function runDoctrineMigration( ?array $installInfo )
    {
        if ( $installInfo ) {
            return $installInfo[InstalationInfoInterface::VERSION_DATA_DOCTRINE_MIGRATION];
        }
        
        $bufferedOutputVersion = new BufferedOutput();
        $this->commandExecutor->runCommand( 'doctrine:migrations:latest', [], $bufferedOutputVersion );
        $doctrineMigration = $bufferedOutputVersion->fetch();
        
        $bufferedOutputMigration = new BufferedOutput();
        $options = [
            'version' => \trim( $doctrineMigration ),
            '--no-interaction' => true,
            '--all-or-nothing' => true,
        ];
        $this->commandExecutor->runCommand( 'doctrine:migrations:migrate', $options, $bufferedOutputMigration );
        
        return $bufferedOutputMigration->fetch();
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
            $process->run( null, ['COMPOSER_HOME' => '/home/vagrant/.composer', 'COMPOSER_ALLOW_SUPERUSER' => 1] );
            
            return $process->getOutput();
        }
        
        return null;
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
            var_dump( $installInfoVersion );
            var_dump( $latestVersion );
            //$this->commandExecutor->runCommand( 'vankosoft:install:info', ['action' => 'update'] );
        }
    }
}
