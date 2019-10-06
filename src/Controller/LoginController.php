<?php

namespace App\Controller;

use Google_Client;
use Google_Service_YouTube;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function index()
    {
        $client = new Google_Client();
        $client->setAuthConfig('client_secret_512185176052-305r534nf5cj7cek48u357u8s5l8oss3.apps.googleusercontent.com.json');
        $client->addScope(GOOGLE_SERVICE_YOUTUBE::YOUTUBE_FORCE_SSL);

        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
            $youtube = new Google_Service_YouTube($client);
//            $channel = $youtube->subscriptions->listSubscriptions('snippet,id,contentDetails,subscriberSnippet', array('mine' => true,'maxResults' => 50));

//            $channel = $youtube->activities->listActivities('snippet', array('mine' => true,'maxResults' => 50,'publishedAfter' => '2006-01-01T01:01:01.0Z'));

            $queryParams = [
                'myRating' => 'like',
                'maxResults' => '50'
//                ,'publishedAfter' => '2006-01-01T01:01:01.0Z'
            ];

            $channel[] = $youtube->videos->listVideos('snippet,contentDetails,statistics', $queryParams);

//            echo "<pre>";
//            var_dump($channel['items']);
//            echo "</pre>";




//-------------
            $i = 0;
            do {
                $queryParams['pageToken'] = $channel[$i]['nextPageToken'];
                $i++;
                $channel[$i] = $youtube->videos->listVideos('snippet,contentDetails,statistics', $queryParams);
//                echo '<pre>';
//                var_dump($channel['items']);
//                echo '</pre>';


                if ($i === 200){
                    break;
                }
//                echo $i;
            } while (count($channel[$i]['items']) > 1 || $i === 1 );

//----------

            $likes = [];

            foreach ($channel as $items){
            foreach ($items['items'] as $videos){
                if (!isset($likes[$videos['snippet']['channelTitle']])){
                    $likes[$videos['snippet']['channelTitle']] = 1;
                }else{
                    ++$likes[$videos['snippet']['channelTitle']];
                }

//                $likes[$videos['snippet']['channelId']] += 1 ;
            }
            }
            arsort($likes);
            echo "<pre>";
            var_dump($likes);
            echo "</pre>";

//            var_dump($response);
//            foreach ($channel['items'] as $channel){
////                echo var_dump($channel['snippet']['title']);
//                echo var_dump($channel);
//            }
        } else {
            $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback';
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
            exit;
        }


        return $this->render('nostalgic/form/nostalgic.html.twig');
    }
}
