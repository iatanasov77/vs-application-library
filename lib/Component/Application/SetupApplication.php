<?php namespace VS\ApplicationBundle\Component\Application;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

use VS\ApplicationBundle\Component\Slug;

class SetupApplication
{
    /**
     * @var ContainerInterface $container
     */
    private $container;
    
    /**
     * @var string $applicationSlug
     */
    private $applicationSlug;
    
    /**
     * @var string $applicationName
     */
    private $applicationName;
    
    public function __construct( ContainerInterface $container )
    {
        $this->container    = $container;
        
    }
    
    public function setupApplication( $applicationName )
    {
        $this->applicationName  = $applicationName;
        $this->applicationSlug  = Slug::generate( $applicationName ); // For Directory Names
        
        $projectRootDir         = $this->getContainer()->get( 'kernel' )->getProjectDir();
        $applicationDirs        = [
            'configs'   => $projectRootDir . '/config/sites/' . $this->applicationSlug,
            'public'    => $projectRootDir . '/public/' . $this->applicationSlug,
            'templates' => $projectRootDir . '/templates/' . $this->applicationSlug,
            'assets'    => $projectRootDir . '/assets/' . $this->applicationSlug,
        ];
        
        // Setup The Application
        $this->setupApplicationDirectories( $applicationDirs );
        $this->setupConfigs();
        $this->setupKernel();
    }
    
    private function setupApplicationDirectories( $applicationDirs ): array
    {
        $filesystem         = new Filesystem();
        $zip                = new \ZipArchive;
        
        try {
            foreach ( $applicationDirs as $key => $dir ) {
                //                 $filesystem->mkdir( $dir, 0777 );
                //                 $filesystem->chown( $dir, 'vagrant', true );
                //                 $filesystem->chgrp( $dir, 'vagrant', true );
                
                try {
                    $dirArchive = $this->getContainer()->get( 'kernel' )
                                        ->locateResource( '@VSApplicationBundle/Resources/application/' . $key . '.zip' );
                    
                    $res = $zip->open( $dirArchive );
                    if ( $res === TRUE ) {
                        $zip->extractTo( $dir );
                        $zip->close();
                    }
                } catch ( \InvalidArgumentException $e ) {
                    // Kernel::locateResource throws \InvalidArgumentException
                    // if the file cannot be found or the name is not valid
                    
                }
            }
        } catch ( IOExceptionInterface $exception ) {
            echo "An error occurred while creating your directory at " . $exception->getPath();
        }
    }
    
    private function setupConfigs()
    {
        
    }
    
    private function setupKernel()
    {
        
    }
}
