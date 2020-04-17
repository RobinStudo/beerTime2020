<?php
namespace App\Service;

use App\Repository\EventRepository;
use App\Service\PaginationService;

class EventService{
    private $eventRepository;
    private $paginationService;

    public function __construct( EventRepository $eventRepository, PaginationService $paginationService ){
        $this->eventRepository = $eventRepository;
        $this->paginationService = $paginationService;
    }

    public function getPaginate( $page ){
        return $this->paginationService->getPaginateResult( $this->eventRepository, $page );
    }

    public function get( $id ){
        return $this->eventRepository->find( $id );
    }

    public function countIncomingEvent(){
        return $this->eventRepository->countIncomingEvent();
    }

    public function count(){
        return $this->eventRepository->count( array() );
    }

    public function search( $query ){
        return $this->eventRepository->searchByName( $query );
    }

    public function getRandom(){
        return $this->eventRepository->getRandom();
    }
}