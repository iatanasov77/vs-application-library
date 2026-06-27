<?php namespace Vankosoft\ApplicationBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FunctionsExtension extends AbstractExtension
{
    /** @var ParameterBagInterface */
    private $params;
    
    public function __construct( ParameterBagInterface $params )
    {
        $this->params = $params;
    }
    
    public function getFunctions(): array
    {
        return [
            new TwigFunction( 'extension_loaded', [$this, 'extensionLoaded'] ),
            new TwigFunction( 'class_exists', [$this, 'classExists'] ),
            new TwigFunction( 'get_parameter', [$this, 'getParameter'] ),
        ];
    }
    
    public function extensionLoaded( string $extension ): bool
    {
        return \extension_loaded( $extension );
    }
    
    public function classExists( string $class ): bool
    {
        return \class_exists( $class );
    }
    
    public function getParameter( string $name )
    {
        return $this->params->has( $name ) ? $this->params->get( $name ) : null;
    }
}