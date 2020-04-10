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
}