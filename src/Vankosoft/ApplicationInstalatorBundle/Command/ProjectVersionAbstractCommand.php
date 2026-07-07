<?php namespace Vankosoft\ApplicationInstalatorBundle\Command;

use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Container\ContainerInterface;
use Vankosoft\ApplicationInstalatorBundle\Model\InstalationInfoInterface;

abstract class ProjectVersionAbstractCommand extends AbstractInstallCommand
{
    /** @var string */
    protected $projectRootPath;
    
    public function __construct(
        ContainerInterface $container,
        ManagerRegistry $doctrine,
        ValidatorInterface $validator,
        string $projectRootPath
    ) {
        parent::__construct( $container, $doctrine, $validator );
        
        $this->projectRootPath = $projectRootPath;
    }
    
    protected function getInstallInfo()
    {
        $bufferedOutput = new BufferedOutput();
        $this->commandExecutor->runCommand( 'vankosoft:install:info', ['json-info' => 'json-info', '--update' => true], $bufferedOutput );
        
        $jsonInfo = $bufferedOutput->fetch();
        $info = \json_decode( $jsonInfo, true );
        var_dump( $info );
        
        $versionInfo = $this->get( 'vs_application_instalator.repository.instalation_info' )->findOneBy([
            'version' => $info[InstalationInfoInterface::VERSION_DATA_PROJECT_VERSION]
        ]);
        
        return $versionInfo ? $info : null;
    }
}
