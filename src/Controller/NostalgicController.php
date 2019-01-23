<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Google_Client;
use Google_Service_YouTube;
use Google_Exception;
use Google_Service_Exception;

class NostalgicController extends AbstractController
{
    /**
     * @Route("/nostalgic/channelId/{slug}", name="nostalgic_search")
     */
    public function search($slug)
    {
        $channelId = $slug;
            // ... perform some action, such as saving the data to the database
            try{
                $client = new Google_Client();
                $client->setApplicationName("yfilter");
                $client->setDeveloperKey($_ENV['YOUTUBE_APIKEY']);

                $service = new Google_Service_YouTube($client);

                $nostalgicDates = [];
                $nostalgicYears= [2018,2017,2016,2015,2014,2013,2012,2011,2010,2009,2008];
                $today = date("m-d");

                foreach ($nostalgicYears as $year ){
                    $nostalgicDates[] = $year . "-" . $today ;
                }
                $searchService = $service->search;

                $searchResults = [];

                foreach ($nostalgicDates as $nostalgicDate){
                    $searchResults[$nostalgicDate] = $searchService->listSearch('id,snippet', array(
                        'maxResults' => '7',
                        'type' => 'video',
                        'channelId' => $channelId,
                        'order' => 'date',
                        'publishedBefore' => $nostalgicDate . "T23:59:59Z",
                        'publishedAfter' => $nostalgicDate . "T00:00:00Z",
                    ));
                }
//                echo "<pre>";
//                var_dump($searchResults);
//                echo "</pre>";
                return $this->render('nostalgic/videos.html.twig', array(
                    'results' => $searchResults,
                ));

            }catch(Google_Exception $ge){
                echo $ge;
            }catch(Google_Service_Exception $gse){
                echo $gse;
            }
        }
}
