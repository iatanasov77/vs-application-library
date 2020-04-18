<?php namespace IA\CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;

use IA\CmsBundle\Form\PageForm;

class PagesController extends ResourceController
{
    public function indexAction( Request $request ) : Response
    {   
        return $this->render( '@IACms/Pages/index.html.twig', [
            'items' => $this->getPagesRepository()->findAll(),
        ]);
    }
    
    public function createAction( Request $request ) : Response
    {
        return $this->editAction( 0, $request );
    }
    
    public function updateAction( Request $request ) : Response
    {
        return $this->editAction( $request->attributes->get( 'id' ), $request );
    }
    
    public function editAction( $id, Request $request )
    {
        $er     = $this->getPagesRepository();
        $oPage  = $id ? $er->findOneBy( ['id' => $id] ) : $er->createNew();
        $form   = $this->createForm( PageForm::class, $oPage );
        
        $form->handleRequest( $request );
        if( $form->isSubmitted() ) { // && $form->isValid()
            $em     = $this->getDoctrine()->getManager();
            $entity = $form->getData();
            
            $entity->setTranslatableLocale( $form['locale']->getData() );
            
            $em->persist( $entity );
            $em->flush();
            
            if ($form->getClickedButton() && 'btnApply' === $form->getClickedButton()->getName()) {
                return $this->redirect( $this->generateUrl( 'ia_cms_page_categories_update', ['id' => $entity->getId()] ) );
            } else {
                return $this->redirect( $this->generateUrl( 'ia_cms_pages_index' ) );
            }
        }

        return $this->render( '@IACms/Pages/update.html.twig', [
            'form' => $form->createView(),
            'item' => $oPage
        ]);
    }
    
    protected function getPagesRepository()
    {
        return $this->get( 'ia_cms.repository.pages' );
    }
}
    