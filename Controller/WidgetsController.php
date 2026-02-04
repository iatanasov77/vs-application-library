<?php namespace Vankosoft\ApplicationBundle\Controller;

use Vankosoft\ApplicationBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

class WidgetsController extends AbstractCrudController
{
    protected function customData( Request $request, $entity = null ): array
    {
        return [
            'translations'  => $this->classInfo['action'] == 'indexAction' ? $this->getTranslations() : [],
        ];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request ): void
    {
        $widgetName = $form->get( 'name' )->getData();
        
        $entity->setCode( $this->get( 'vs_application.slug_generator' )->generate( $widgetName ) );
        
        $selectedRoles  = \json_decode( $request->request->get( 'selectedRoles' ), true );
        $this->buildRoles( $entity, $selectedRoles );
    }
    
    private function buildRoles( &$entity, array $roles ): void
    {
        //var_dump( $roles ); die;
        $repo   = $this->get( 'vs_users.repository.user_roles' );
        
        $entity->setAllowedRoles( new ArrayCollection() );
        foreach ( $roles as $r ) {
            $entity->addAllowedRole( $repo->find( $r['id'] ) );
        }
    }
}