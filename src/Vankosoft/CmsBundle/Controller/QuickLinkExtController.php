<?php namespace Vankosoft\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Vankosoft\CmsBundle\Repository\QuickLinksCategoryRepository;
use Vankosoft\CmsBundle\Repository\QuickLinkRepository;
use Vankosoft\CmsBundle\Form\QuickLinkForm;

class QuickLinkExtController extends AbstractController
{
    /** @var ManagerRegistry */
    protected $doctrine;
    
    /** @var QuickLinksCategoryRepository */
    protected $quickLinkCategoryRepository;
    
    /** @var QuickLinkRepository */
    protected $quickLinkRepository;
    
    /** @var FactoryInterface */
    protected $quickLinkFactory;
    
    public function __construct(
        ManagerRegistry $doctrine,
        QuickLinksCategoryRepository $quickLinkCategoryRepository,
        QuickLinkRepository $quickLinkRepository,
        FactoryInterface $quickLinkFactory
    ) {
        $this->doctrine                     = $doctrine;
        $this->quickLinkCategoryRepository  = $quickLinkCategoryRepository;
        $this->quickLinkRepository          = $quickLinkRepository;
        $this->quickLinkFactory             = $quickLinkFactory;
    }
    
    public function editQuickLink( $categoryId, $itemId, $locale, Request $request ): Response
    {
        $category   = $this->quickLinkCategoryRepository->find( $categoryId );
        $em         = $this->doctrine->getManager();
        
        $itemId     = intval( $itemId );
        $quickLink     = $itemId ? $this->quickLinkRepository->find( $itemId ) : $this->quickLinkFactory->createNew();
        $formAction = $itemId ? 
                        $this->generateUrl( 'vs_cms_quick_link_update', ['categoryId' => $categoryId, 'id' => $itemId] ) :
                        $this->generateUrl( 'vs_cms_quick_link_create', ['categoryId' => $categoryId] );
        $formMethod     = $itemId ? 'PUT' : 'POST';
        
        if ( $locale != $request->getLocale() ) {
            $quickLink->setTranslatableLocale( $locale );
            $em->refresh( $quickLink );
        }
        
        $form   = $this->createForm( QuickLinkForm::class, $quickLink, [
            'action'    => $formAction,
            'method'    => $formMethod,
            'data'      => $quickLink,
            'category'  => $category,
        ]);
        
        return $this->render( '@VSCms/Pages/QuickLinks/quick_link_form.html.twig', [
            'form'          => $form->createView(),
            'categoryId'    => $categoryId,
            'item'          => $quickLink,
        ]);
    }
    
    public function deleteQuickLink( $categoryId, $itemId, Request $request ): Response
    {
        $em         = $this->doctrine->getManager();
        $quickLink  = $this->quickLinkRepository->find( $itemId );
        
        $em->remove( $quickLink );
        $em->flush();
        
        return $this->redirectToRoute( 'vs_cms_quick_link_category_update', ['id' => $categoryId] );
    }
}