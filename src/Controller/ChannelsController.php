<?php


namespace App\Controller;

use App\Entity\SearchNostalgic;
use App\Form\YSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Google_Client;
use Google_Service_YouTube;
use Google_Exception;
use Google_Service_Exception;

class ChannelsController extends AbstractController
{
    /**
     * @Route("/linkyoutube", name="link_youtube")
     */
    public function linkYoutube()
    {

        try {
            /**
             * Sample PHP code for youtube.channels.list
             * See instructions for running these code samples locally:
             * https://developers.google.com/explorer-help/guides/code_samples#php
             */

            $client = new Google_Client();
            $client->setApplicationName("yfilter");
            $client->setScopes([
                'https://www.googleapis.com/auth/youtube.readonly',
            ]);

// TODO: For this request to work, you must replace
//       "YOUR_CLIENT_SECRET_FILE.json" with a pointer to your
//       client_secret.json file. For more information, see
//       https://cloud.google.com/iam/docs/creating-managing-service-account-keys
            $client->setAuthConfig('client_secret.json');
            $client->setAccessType('offline');

// Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open this link in your browser:\n%s\n", $authUrl);
            print('Enter verification code: ');
            $authCode = trim(fgets(STDIN));

// Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

// Define service object for making API requests.
            $service = new Google_Service_YouTube($client);

            $queryParams = [
                'mine' => true
            ];

            $response = $service->channels->listChannels('snippet,contentDetails,statistics', $queryParams);
            print_r($response);
        } catch (Google_Exception $ge) {
            echo $ge;
        } catch (Google_Service_Exception $gse) {
            echo $gse;
        }

        var_dump('hello world');


        $searchNostalgic = new SearchNostalgic();

        $form = $this->createForm(YSearchType::class, $searchNostalgic, array(
            'action' => '/search'
        ));

        return $this->render('nostalgic/form/nostalgic.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
