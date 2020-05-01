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
    
    /** This function has to return a search form.
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

        //  dd($result->getContent());

        return $this->render('games/index.html.twig', [
            'controller_name' => 'GamesController',
        ]);
    }
    //todo
    /* Find game on base of controller.
        URL would be /games/battelfield
    */

    /**This function should return a url with the game name. There should be two ways to get to this function one through a post from a form and one through a get from the name.
     * How i would do it or think is should is make a get controller
     * 
     * There are actually four parts to showing the games you are looking for
     * 1 is type in the name in a form that does a post
     * I am already a step to fazr with the urls i just have to find the games so i should have a controller on /games/search or not even an keep /search and if there is a post show results and else show nothing.
     * 
     * Route("/gamestest", name="gamestest")
     */
    // public function searchGames(Request $request) {

    // }

}
