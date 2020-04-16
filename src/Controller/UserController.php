<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="user_register")
     */
    public function register( Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $em )
    {
        $user = new User();
        $form = $this->createForm( RegisterType::class, $user );

        $form->handleRequest( $request );
        if( $form->isSubmitted() && $form->isValid() ){
            $plain = $user->getPlainPassword();
            $password = $encoder->encodePassword( $user, $plain );
            $user->setPassword( $password );
            $user->setRoles( ['ROLE_USER'] );

            $em->persist( $user );
            $em->flush();

            $this->addFlash( 'success', "Votre compte à bien été créé" );
            return $this->redirectToRoute( 'event_list' );
        }

        return $this->render('user/register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
