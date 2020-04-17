<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpClient\HttpClient;

class AjaxController extends AbstractController
{
    /**
     * @Route("/ajax/address", name="ajax_address")
     */
    public function address( Request $request )
    {
        $address = $request->query->get('address');

        $client = HttpClient::create();
        $url = 'https://api-adresse.data.gouv.fr/search/?q=' . $address;
        $response = $client->request( 'GET', $url );
        $content = $response->toArray();

        return new JsonResponse( array(
            'status' => true,
            'results' => $content['features'],
        ));
    }
}
