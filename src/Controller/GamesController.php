<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Lgdb;


class GamesController extends AbstractController
{

    private $gameService;

    public function __construct() {
        $this->gameService = new Lgdb();
    }

    /**
     * @Route("/games", name="games")
     */
    public function index()
    {
        // $client = $this->httpClient::create(['headers' => [
        //     'user-key' => 'a8a077c98e0266d85f59744efc9858db',
        // ]]);

        // $response = $client->request('POST', 'https://api-v3.igdb.com/game_versions/', [
        //     'body' => 'fields game.name,games.*; where game = 28540;',
        // ]);
        // $statusCode = $response->getStatusCode();
        // echo $statusCode;
        // //    dd($response);
        // dd($response->getContent());

        $result = $this->gameService->gameVersions('fields game.name,games.*; where game = 28540;');

        dd($result->getContent());

        return $this->render('games/index.html.twig', [
            'controller_name' => 'GamesController',
        ]);
    }
    //todo
    /* Find game on base of controller.
        URL would be /games/battelfield
    */
}
