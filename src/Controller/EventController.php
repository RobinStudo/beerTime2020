<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\EventService;
use App\Entity\Event;
use App\Repository\PlaceRepository;
use App\Repository\UserRepository;
use App\Entity\Place;
use App\Form\EventType;

class EventController extends AbstractController
{
    private $eventService;

    public function __construct( EventService $eventService ){
        $this->eventService = $eventService;
    }

    /**
     * @Route("/events", name="event_list")
     */
    public function list( Request $request )
    {
        $query = $request->query->get('query');

        if( !empty( $query ) ){
            $events = $this->eventService->search( $query );
        }else{
            $events = $this->eventService->getAll();
        }

        return $this->render( 'event/list.html.twig', array(
            'events' => $events,
            'nIncomingEvents' => $this->eventService->countIncomingEvent(),
        ));
    }

    /**
     * @Route("/event/new", name="event_new")
     */
    public function new( Request $request, EntityManagerInterface $em, UserRepository $userRepository )
    {
        $event = new Event();
        $form = $this->createForm( EventType::class, $event );

        $form->handleRequest( $request );
        if( $form->isSubmitted() && $form->isValid() ){
            $owner = $userRepository->find( 1 );
            $event->setOwner( $owner );

            $em->persist( $event );
            $em->flush();

            $this->addFlash( 'success', "Votre événement \"" . $event->getName() . "\" à bien été créé" );
            return $this->redirectToRoute( 'event_show', array(
                'id' => $event->getId(),
            ));
        }

        return $this->render( 'event/form.html.twig', array(
            'form' => $form->createView(),
            'isNew' => true,
        ));
    }

    
    /**
     * @Route("/event/random", name="event_random")
     */
    public function random()
    {
        return $this->redirectToRoute( 'event_show', array(
            'id' => $this->eventService->getRandom()
        ));
    }

    /**
     * @Route("/event/{id}", name="event_show", requirements={"id"="\d+"})
     */
    public function show( $id )
    {
        return $this->render( 'event/show.html.twig', array(
            'event' => $this->eventService->get( $id ),
        ));
    }

    /**
     * @Route("/event/{id}/join", name="event_join", requirements={"id"="\d+"})
     */
    public function join()
    {
        return new Response('Rejoindre un event');
    }

    /**
     * @Route("/event/{id}/update", name="event_update")
     */
    public function update( Event $event, Request $request, EntityManagerInterface $em )
    {
        $form = $this->createForm( EventType::class, $event );

        $form->handleRequest( $request );
        if( $form->isSubmitted() && $form->isValid() ){
            $em->flush();

            $this->addFlash( 'success', "Votre événement \"" . $event->getName() . "\" à bien été modifié" );
            return $this->redirectToRoute( 'event_show', array(
                'id' => $event->getId(),
            ));
        }

        return $this->render( 'event/form.html.twig', array(
            'form' => $form->createView(),
            'isNew' => false,
        ));
    }

    /**
     * @Route("/event/{id}/remove", name="event_remove")
     */
    public function remove( Event $event, EntityManagerInterface $em )
    {
        $em->remove( $event );
        $em->flush();

        $this->addFlash( 'success', "Votre événement \"" . $event->getName() . "\" à bien été supprimé" );
        return $this->redirectToRoute( 'event_list' );
    }
}
