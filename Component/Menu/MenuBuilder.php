<?php namespace IA\CmsBundle\Component\Menu;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Yaml\Yaml;

use Knp\Menu\FactoryInterface;
use Knp\Menu\Matcher\Voter\RouteVoter;

class MenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;
    
    protected $securityContext;
    
    protected $isLoggedIn;
    
    protected $isAdmin;
    
    protected $menuConfig;
    
    public function __construct( AuthorizationChecker $securityContext, string $config_file )
    {
        $this->securityContext  = $securityContext;
        
        $config                 = Yaml::parse( file_get_contents( $config_file ) );
        $this->menuConfig       = $config['ia_cms']['menu']['mainMenu'];
        
        $this->isLoggedIn       = $this->securityContext->isGranted( 'IS_AUTHENTICATED_FULLY' );
        $this->isAdmin          = $this->securityContext->isGranted( 'ROLE_ADMIN' );
    }
    
    public function mainMenu( FactoryInterface $factory )
    {
        $menu       = $factory->createItem( 'root' );
        
        $this->build( $menu, $this->menuConfig );

        return $menu;
    }
    
    public function profileMenu( FactoryInterface $factory )
    {
        $menu = $factory->createItem('root');
        
        $menu->addChild('My Profile', array('route' => 'ia_users_profile_show', 'attributes' => array('iconClass' => 'fas fa-user mr-2')));
        $menu->addChild('Log Out', array('route' => 'app_logout', 'attributes' => array('iconClass' => 'fas fa-power-off mr-2')));
        $menu->addChild('Documentation', array('uri' => 'javascript:;', 'attributes' => array('iconClass' => 'fas fa-cog mr-2')));
        
        return $menu;
    }
    
    public function breadcrumbsMenu( FactoryInterface $factory )
    {
        $bcmenu = $this->mainMenu( $factory );
        return $this->getCurrentMenuItem($bcmenu) ?: $factory->createItem('Edit');
    }
    
    public function getCurrentMenuItem($menu)
    {
        $voter = new RouteVoter($this->container->get('request_stack'));
        
        foreach ($menu as $item) {
            if ($voter->matchItem($item)) {
                return $item;
            }
            
            if ($item->getChildren() && $currentChild = $this->getCurrentMenuItem($item)) {
                return $currentChild;
            }
        }
        
        return null;
    }
    
    
    private function build( &$menu, $config )
    {
        foreach ( $config as $mg ) {
            $menu->addChild( $mg['name'], [
                'uri'       => isset( $mg['uri'] ) ? $mg['uri'] : null,
                'route'     => isset( $mg['route'] ) ? $mg['route'] : null,
                'attributes'=> isset( $mg['attributes'] ) ? $mg['attributes'] : [],
            ]);
            
            if ( isset( $mg['childs'] ) && is_array( $mg['childs'] ) ) {
                $this->build( $menu[$mg['name']], $mg['childs'] );
            }
        }
    }
}
