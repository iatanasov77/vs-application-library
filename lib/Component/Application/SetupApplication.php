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
        
        $projectRootDir         = $this->container->get( 'kernel' )->getProjectDir();
        $applicationDirs        = [
            'configs'   => $projectRootDir . '/config/sites/' . $this->applicationSlug,
            'public'    => $projectRootDir . '/public/' . $this->applicationSlug,
            'templates' => $projectRootDir . '/templates/' . $this->applicationSlug,
            'assets'    => $projectRootDir . '/assets/' . $this->applicationSlug,
        ];
        
        // Setup The Application
        $this->setupApplicationDirectories( $applicationDirs );
        $this->setupApplicationKernel();
        $this->setupApplicationHomePage();
    }
    
    private function setupApplicationDirectories( $applicationDirs ): void
    {
        $filesystem         = new Filesystem();
        $zip                = new \ZipArchive;
        
        try {
            foreach ( $applicationDirs as $key => $dir ) {
                //                 $filesystem->mkdir( $dir, 0777 );
                //                 $filesystem->chown( $dir, 'vagrant', true );
                //                 $filesystem->chgrp( $dir, 'vagrant', true );
                
                try {
                    $dirArchive = $this->container->get( 'kernel' )
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
    
    private function setupApplicationKernel()
    {
        $filesystem         = new Filesystem();
        $projectRootDir     = $this->container->get( 'kernel' )->getProjectDir();
        $twig               = $this->container->get( 'twig' );
        $kernelClass        = preg_replace( '/\s+/', '', $this->applicationName ) . 'Kernel';
        
        // Write Application Kernel
        $applicationKernel  = $twig->render( '@VSApplication/Application/Kernel.php.twig', [
            'kernelClass'       => $kernelClass,
            'applicationSlug'   => $this->applicationSlug,
        ]);
        $filesystem->dumpFile( $projectRootDir . '/src/' . $kernelClass . '.php', $applicationKernel );
        
        // Write Application Entry Point
        $applicationIndex  = $twig->render( '@VSApplication/Application/index.php.twig', [
            'kernelClass'       => $kernelClass,
        ]);
        $filesystem->dumpFile( $projectRootDir . '/public/' . $this->applicationSlug . '/index.php', $applicationIndex );
    }
    
    private function setupApplicationHomePage()
    {
        $filesystem             = new Filesystem();
        $projectRootDir         = $this->container->get( 'kernel' )->getProjectDir();
        
        // Write Application Home Page
        $applicationHomePage    = str_replace(
                                        "__application_slug__", $this->applicationSlug,
                                        file_get_contents( $projectRootDir . '/templates/' . $this->applicationSlug . '/pages/home.html.twig' )
                                    );
        $filesystem->dumpFile( $projectRootDir . '/templates/' . $this->applicationSlug . '/pages/home.html.twig', $applicationHomePage );
        
        // Write Application Home Controller
        $applicationHomeController  = str_replace(
                                        "__application_slug__", $this->applicationSlug,
                                        file_get_contents( $projectRootDir . '/src/Controller/Application/DefaultController.php' )
                                    );
        $filesystem->dumpFile( $projectRootDir . '/src/Controller/Application/DefaultController.php', $applicationHomeController );
    }
}
