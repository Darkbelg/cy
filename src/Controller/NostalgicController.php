<?php


namespace App\Controller;

use Google_Http_Batch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Google_Client;
use Google_Service_YouTube;
use Google_Exception;
use Google_Service_Exception;

class NostalgicController extends AbstractController
{

    const HALF_WEEK = 3.5*24*60*60;
    const HALF_DAY = 12*60*60;

    /**
     * @Route("/nostalgic/channel/{slug}/period/{period}", name="nostalgic_search")
     */
    public function search($slug,$period)
    {
        $channel = $slug;
            // ... perform some action, such as saving the data to the database
            try{
                $client = new Google_Client();
                $client->setApplicationName("yfilter");
                $client->setDeveloperKey($_ENV['YOUTUBE_APIKEY']);

                $service = new Google_Service_YouTube($client);

                $nostalgicDates = [];

                $channelCreated = $service->channels->listChannels('snippet', array(
                    'id' => $channel,
                    'maxResults' => '1'
                ));

                $channelCreated = $channelCreated['items'][0]['snippet']['publishedAt'];

                $client->setUseBatch(true);
                $batch = new Google_Http_Batch($client,false,null,"batch/youtube/v3/");

                $today = time();

                $nostalgicYears = [];
                for ($i = 2019;$i >= 2000;$i--){
                    if(date_create($channelCreated)->format("Ymd") > $i . date("md",$today) ) {
                        break;
                    }
                    $nostalgicYears[] = $i;
                }

                if($period == "day"){
                    $todayMorning = $today - 12*60*60;
                    $todayEvening = $today + 12*60*60;
                }else{
                    $todayMorning = $today - 3.5*24*60*60;
                    $todayEvening = $today + 3.5*24*60*60;
                }

                foreach ($nostalgicYears as $year ){
                    $nostalgicDates[$year]['morning'] = $year . "-" . date("m-d\TH:i:s\Z",$todayMorning) ;
                    $nostalgicDates[$year]['evening'] = $year . "-" . date("m-d\TH:i:s\Z",$todayEvening)  ;
                }
                $searchService = $service->search;

                $searchResults = [];

                foreach ($nostalgicDates as $year => $nostalgicDate){
                    $request = $searchService->listSearch('id,snippet', array(
                        'maxResults' => '7',
                        'type' => 'video',
                        'channelId' => $channel,
                        'order' => 'date',
                        'publishedBefore' => $nostalgicDate['evening'],
                        'publishedAfter' => $nostalgicDate['morning'],
                    ));
                    $batch->add($request,$year);
                }
                foreach ($nostalgicDates as $year => $nostalgicDate){
                    $nostalgicDates['response-'.$year] = date("d F",$today) . " ". $year;
                }
                $searchResults = $batch->execute();

                return $this->render('nostalgic/videos.html.twig', array(
                    'results' => $searchResults, 'channelCreated' =>$channelCreated, 'nostalgicDates' => $nostalgicDates
                ));

            }catch(Google_Exception $ge){
                echo $ge;
            }catch(Google_Service_Exception $gse){
                echo $gse;
            }
        }
}
