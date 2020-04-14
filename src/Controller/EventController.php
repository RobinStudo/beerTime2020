<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\EventService;

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
    public function new()
    {
        return new Response('Création d\'un event');
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
}
