<?php

namespace App\Controller;

use Google_Client;
use Google_Service_YouTube;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Oauth2callbackController extends AbstractController
{
    /**
     * @Route("/oauth2callback", name="oauth2callback")
     */
    public function index()
    {

        $client = new Google_Client();
        $client->setAuthConfigFile('client_secret_512185176052-305r534nf5cj7cek48u357u8s5l8oss3.apps.googleusercontent.com.json');
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback');
        $client->addScope(GOOGLE_SERVICE_YOUTUBE::YOUTUBE_FORCE_SSL);

        if (! isset($_GET['code'])) {
            $auth_url = $client->createAuthUrl();
            header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        } else {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/login';
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }
        exit;
    }
}
