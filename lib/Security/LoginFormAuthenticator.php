<?php namespace VS\UsersBundle\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\HttpFoundation\Cookie;

use VS\UsersBundle\Repository\UsersRepository;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator implements PasswordAuthenticatedInterface
{
    use TargetPathTrait;
    
    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    
    private $userRepository;
    private $encoderFactory;
    
    private $params;
    
    public function __construct (
        UrlGeneratorInterface $urlGenerator,
        CsrfTokenManagerInterface $csrfTokenManager,
        EncoderFactoryInterface $encoderFactory,
        UsersRepository $userRepository,
        array $params
    ) {
        $this->urlGenerator     = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->encoderFactory   = $encoderFactory;
        $this->userRepository   = $userRepository;
        $this->params           = $params;
    }
    
    public function supports( Request $request )
    {
        return $this->params['loginRoute'] === $request->attributes->get( '_route' ) && $request->isMethod( 'POST' );
    }
    
    public function getCredentials( Request $request )
    {
        $credentials = [
            $this->params['loginBy']    => $request->request->get( '_' . $this->params['loginBy'] ),
            'password'                  => $request->request->get( '_password' ),
            'csrf_token'                => $request->request->get( '_csrf_token' ),
        ];
        /* */
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials[$this->params['loginBy']]
        );
        
        return $credentials;
    }
    
    public function getUser( $credentials, UserProviderInterface $userProvider )
    {
        $token = new CsrfToken( 'authenticate', $credentials['csrf_token'] );
        if ( ! $this->csrfTokenManager->isTokenValid( $token ) ) {
            throw new InvalidCsrfTokenException();
        }
        
        $user = $this->userRepository->findOneBy( [$this->params['loginBy'] => $credentials[$this->params['loginBy']]] );
        
        if ( ! $user ) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException( ucfirst( $this->params['loginBy'] ) . ' could not be found.' );
        }
        
        if ( ! $user->isEnabled() ) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException( 'User not enabled !' );
        }
        
        return $user;
    }
    
    public function checkCredentials( $credentials, UserInterface $user )
    {
        $passwordEncoder    = $this->encoderFactory->getEncoder( $user );
        
        //return $passwordEncoder->isPasswordValid( $user, $credentials['password'] );
        return $passwordEncoder->isPasswordValid( $user->getPassword(), $credentials['password'], $user->getSalt() );
    }
    
    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function getPassword( $credentials ): ?string
    {
        return $credentials['password'];
    }
    
    public function onAuthenticationSuccess( Request $request, TokenInterface $token, $providerKey )
    {
        if ( $targetPath = $this->getTargetPath( $request->getSession(), $providerKey ) ) {
            $response   = new RedirectResponse( $targetPath );
        } else {
            // redirect to some "app_homepage" route - of wherever you want
            $response   = new RedirectResponse( $this->urlGenerator->generate( $this->params['defaultRedirect'] ) );
        }
        
        // $this->getRequest()->getHost()
        
        // Before Symfony 5
        Cookie::create(
            'foo',
            'bar',
            time() + $this->params['apiTokenExpires'],
            '/', $this->params['apiTokenDomain'],   // '.example.com'
            true,
            true
        );
        
        // After Symfony 5
//         $cookieToken = Cookie::create( 'api_token' )
//                             ->withValue( $token->getUser()->getApiToken() )
//                             ->withExpires( time() + $this->params['apiTokenExpires'] )
//                             ->withDomain( $this->params['apiTokenDomain'] )    // '.example.com'
//                             ->withSecure( true )
//                             ->withHttpOnly(true);
        
        $response->headers->setCookie( $cookieToken );
        
        return $response;
    }
    
    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate( $this->params['loginRoute'] );
    }
}
