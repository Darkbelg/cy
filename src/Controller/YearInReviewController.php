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
use Symfony\Component\Validator\Constraints\Date;

class YearInReviewController extends AbstractController
{

    const HALF_WEEK = 3.5 * 24 * 60 * 60;
    const HALF_DAY = 12 * 60 * 60;

    /**
     * @Route("/yearinreview/channel/{channel}/period/{period}", name="year_in_review_search")
     */
    public function search($channel, $period)
    {
       return $this->searchYearInReview( $channel,$period);
    }

    /**
     * @Route("/yearinreview/channel/{channel}/period/{period}/page/{page}", name="year_in_review_search_page")
     */
    public function searchNextPage($channel, $period, $page)
    {
       return $this->searchYearInReview( $channel,$period,$page);
    }

    private function searchYearInReview( $channel,$period,$page = null){

        // ... perform some action, such as saving the data to the database
        try {
            $client = new Google_Client();
            $client->setApplicationName("yfilter");
            $client->setDeveloperKey($_ENV['YOUTUBE_APIKEY']);

            $service = new Google_Service_YouTube($client);

            $nostalgicDates = [];

            $channelData = $service->channels->listChannels('snippet,statistics,brandingSettings', array(
                'id' => $channel,
                'maxResults' => '1'
            ));

            $channelCreated = $channelData['items'][0]['snippet']['publishedAt'];

            $years = [];
            for ($i = 2019;$i >= date_create($channelCreated)->format("Y");$i--){
                $years[] = $i;
            }

            $beginYear = new \DateTime($period . '-01-01T00:00:00');
            $endYear = new \DateTime($period . '-12-31T23:59:00');

            $searchService = $service->search;
            $searchResults = $searchService->listSearch('id,snippet', array(
                'maxResults' => '50',
                'type' => 'video',
                'channelId' => $channel,
                'order' => 'date',
                'publishedAfter' =>  $beginYear->format("Y-m-d\TH:i:s\Z"),
                'publishedBefore' => $endYear->format("Y-m-d\TH:i:s\Z"),
                'pageToken' => $page
            ));

            $PageToken["next"] = $searchResults["nextPageToken"];
            $PageToken["prev"] = $searchResults["prevPageToken"];

            foreach ($searchResults as $searchResult){
                if (!isset($videoIds)){
                    $videoIds['id'] = $searchResult["id"]["videoId"];
                }else{
                    $videoIds['id'] .= ',' . $searchResult["id"]["videoId"];
                }
            }

            $searchResults = $service->videos->listVideos('statistics,contentDetails,snippet,id', $videoIds);

            return $this->render('year_in_review/videos.html.twig', array(
                'results' => $searchResults,'channel' => $channelData,'period' => $period,'pageToken' => $PageToken, 'years' =>  $years,'current_url' => $_SERVER["REQUEST_URI"]
            ));

        } catch (Google_Service_Exception $ge) {
            echo $ge;
        } catch
        ( Google_Exception $gse) {
            echo $gse;
        }
    }
}
