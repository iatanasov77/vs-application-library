<?php namespace Vankosoft\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Vankosoft\ApplicationBundle\Component\Status;
use Vankosoft\UsersBundle\Security\SecurityBridge;
use Vankosoft\UsersBundle\Model\UserInterface;
use Vankosoft\UsersBundle\Component\UserException;

class UsersNotificationsController extends AbstractController
{
    /** @var ManagerRegistry */
    protected $doctrine;
    
    /** @var SecurityBridge */
    protected $securityBridge;
    
    /** @var RepositoryInterface */
    protected $notificationsRepository;
    
    public function __construct(
        ManagerRegistry $doctrine,
        SecurityBridge $securityBridge,
        RepositoryInterface $usersRepository
    ) {
        $this->doctrine                 = $doctrine;
        $this->securityBridge           = $securityBridge;
        $this->notificationsRepository  = $notificationsRepository;
    }
    
    public function setAllReaded( Request $request ): Response
    {
        $user   = $this->securityBridge->getUser();
        $userIsValid    = ( $user instanceof UserInterface );
        $hasError       = ! $userIsValid;
        
        if ( ! $hasError ) {
            $em = $this->doctrine->getManager();
            foreach ( $user->getNotifications() as $not ) {
                $not->setReaded( true );
                $em->persist( $not );
            }
            $em->flush();
        }
        
        if( $request->isXmlHttpRequest() ) {
            return new JsonResponse([
                'status'    => $hasError ? Status::STATUS_ERROR : Status::STATUS_OK,
                'message'   => $hasError ? 'Invalid User !!!' : 'User is Valid !!!',
            ]);
        } else {
            if ( $hasError ) {
                throw new UserException( 'Invalid User !!!' );
            }
            
            return $this->redirectToRoute( 'vs_users_profile_show' );
        }
    }
    
    public function showNotification( $id, Request $request ): Response
    {
        $notification   = $this->notificationsRepository->find( $id );
        $user           = $this->securityBridge->getUser();
        $userIsValid    = ( $user instanceof UserInterface );
        $hasError       = ! $userIsValid || $user->getId() != $notification->getUser()->getId();
        
        if ( ! $hasError ) {
            $em = $this->doctrine->getManager();
            
            $notification->setReaded( true );
            $em->persist( $notification );
            $em->flush();
        }
        
        if( $request->isXmlHttpRequest() ) {
            return new JsonResponse([
                'status'    => $hasError ? Status::STATUS_ERROR : Status::STATUS_OK,
                'message'   => $hasError ? 'Invalid User !!!' : 'User is Valid !!!',
                'response'  => $hasError ? '' : $this->render( '@VSUsers/Profile/notification.html.twig', ['notification'  => $notification] ),
            ]);
        } else {
            if ( $hasError ) {
                throw new UserException( 'Invalid User !!!' );
            }
            
            return $this->render( '@VSUsers/Profile/notification.html.twig', [
                'notification'  => $notification,
            ]);
        }
    }
}