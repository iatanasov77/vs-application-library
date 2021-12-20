<?php namespace Vankosoft\ApplicationBundle\Component\Context;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Vankosoft\ApplicationBundle\Model\Interfaces\ApplicationInterface;

final class ApplicationContext implements ApplicationContextInterface
{
    private RequestResolverInterface $requestResolver;
    
    private RequestStack $requestStack;
    
    public function __construct( RequestResolverInterface $requestResolver, RequestStack $requestStack )
    {
        $this->requestResolver  = $requestResolver;
        $this->requestStack     = $requestStack;
    }
    
    public function getApplication() : ApplicationInterface
    {
        try {
            return $this->getApplicationForRequest( $this->getMasterRequest() );
        } catch ( \UnexpectedValueException $exception ) {
            throw new ApplicationNotFoundException( null, $exception );
        }
    }
    
    private function getApplicationForRequest( Request $request ): ApplicationInterface
    {
        $application    = $this->requestResolver->findApplication( $request );
        
        $this->assertApplicationWasFound( $application );
        
        return $application;
    }
    
    private function getMasterRequest(): Request
    {
        $masterRequest = $this->requestStack->getMasterRequest();
        if ( null === $masterRequest ) {
            throw new \UnexpectedValueException( 'There are not any requests on request stack' );
        }
        
        return $masterRequest;
    }
    
    private function assertApplicationWasFound( ?ApplicationInterface $application ): void
    {
        if ( null === $application ) {
            throw new \UnexpectedValueException( 'Application was not found for given request' );
        }
    }
}
