<?php
namespace App\Service;

use App\Repository\EventRepository;

class EventService{
    private $eventRepository;

    public function __construct( EventRepository $eventRepository ){
        $this->eventRepository = $eventRepository;
    }

    public function getAll(){
        return $this->eventRepository->findAll();
    }

    public function get( $id ){
        return $this->eventRepository->find( $id );
    }

    public function countIncomingEvent(){
        return $this->eventRepository->countIncomingEvent();
    }

    public function search( $query ){
        return $this->eventRepository->searchByName( $query );
    }

    public function getRandom(){
        // TODO
        // Appeler et retourner la fonction du repo
    }
}