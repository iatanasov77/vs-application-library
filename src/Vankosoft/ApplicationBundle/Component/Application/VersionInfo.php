<?php namespace Vankosoft\ApplicationBundle\Component\Application;

use Symfony\Component\Filesystem\Filesystem;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Vankosoft\ApplicationInstalatorBundle\Model\InstalationInfoInterface;

final class VersionInfo
{
    /** @var RepositoryInterface */
    private $instalationInfoRepository;
    
    /** @var FactoryInterface */
    private $instalationInfoFactory;
    
    /** @var string */
    private $projectDir;
    
    public function __construct(
        RepositoryInterface $instalationInfoRepository,
        FactoryInterface $instalationInfoFactory,
        string $projectDir
    ) {
        $this->instalationInfoRepository    = $instalationInfoRepository;
        $this->instalationInfoFactory       = $instalationInfoFactory;
        $this->projectDir                   = $projectDir;
    }
    
    public function getCurrentVersion(): string
    {
        $filesystem     = new Filesystem();
        $versionFile    = $this->projectDir . '/VERSION';
        
        $currentVersion = $filesystem->exists( $versionFile ) ?
                            \file_get_contents( $versionFile ) :
                            InstalationInfoInterface::VERSION_UNDEFINED;
        
        return \trim( $currentVersion );
    }
    
    public function getVersionInfo( string $currentVersion ): InstalationInfoInterface
    {
        $versionInfo    = $this->instalationInfoRepository->findOneBy( ['version' => $currentVersion] );
        if ( ! $versionInfo ) {
            $versionInfo    = $this->instalationInfoFactory->createNew();
            $versionInfo->setVersion( $currentVersion );
        }
        
        return $versionInfo;
    }
}
