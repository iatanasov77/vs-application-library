<?php namespace Vankosoft\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;

use Vankosoft\UsersBundle\Security\SecurityBridge;
use Vankosoft\UsersBundle\Controller\UserRolesAwareTrait;

class WidgetsExtController extends AbstractController
{
    use UserRolesAwareTrait;
    
    /** @var SecurityBridge */
    protected $securityBridge;
    
    /** @var RepositoryInterface */
    protected $widgetsRepository;
    
    /** @var RepositoryInterface */
    protected $usersRolesRepository;
    
    public function __construct(
        SecurityBridge $securityBridge,
        RepositoryInterface $widgetsRepository,
        RepositoryInterface $usersRolesRepository
    ) {
        $this->securityBridge       = $securityBridge;
        $this->widgetsRepository    = $widgetsRepository;
        $this->usersRolesRepository = $usersRolesRepository;
    }
    
    public function rolesEasyuiComboTreeWithSelectedSource( $editWidgetId, Request $request ): JsonResponse
    {
        $currentUser    = $this->securityBridge->getUser();
        $editWidget     = $editWidgetId ? $this->widgetsRepository->find( $editWidgetId ) : null;
        
        $selectedRoles  = $editWidget  ? $editWidget ->getAllowedRolesFromCollection() : [];
        $data           = [];
        
        $topRoles       = new ArrayCollection( $this->usersRolesRepository->findBy( ['parent' => null] ) );
        
        $rolesTree      = [];
        $this->getRolesTree(  $topRoles, $rolesTree, $currentUser->getAllowedRoles() );
        $this->buildEasyuiCombotreeDataFromCollection( $rolesTree, $data, $selectedRoles );
        
        return new JsonResponse( $data );
    }
}