<?php namespace VS\ApplicationBundle\DataCollector;

use Symfony\Bundle\FrameworkBundle\DataCollector\AbstractDataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Tutorial: https://symfony.com/doc/current/profiler/data_collector.html
 *
 */
class VsApplicationCollector extends AbstractDataCollector
{
    /** KernelInterface $appKernel */
    private $appKernel;
    
    public function __construct( KernelInterface $appKernel )
    {
        $this->appKernel = $appKernel;
    }
    
    public function collect( Request $request, Response $response, \Throwable $exception = null )
    {
        $this->data = [
            'version'       => file_get_contents( $this->appKernel->getProjectDir() . '/VERSION' ),
            'dependencies'  => [],
        ];
    }
    
    public static function getTemplate(): ?string
    {
        return '@VSApplication/DataCollector/vs_application.html.twig';
    }
    
    public function getVersion()
    {
        return $this->data['version'];
    }
    
    public function getDependencies()
    {
        return $this->data['dependencies'];
    }
}
