<?php


namespace App\Controller;

use App\Entity\SearchNostalgic;
use App\Form\YSearchChannel;
use App\Form\YSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Google_Client;
use Google_Service_YouTube;
use Google_Exception;
use Google_Service_Exception;
use Symfony\Component\HttpFoundation\Cookie;

class SearchChannelsController extends AbstractController
{
    /**
     * @Route("/search/{appName}", name="search")
     */
    public function search(Request $request,$appName)
    {

        $this->addFlash(
            'notice',
            'Your changes were saved!'
        );
        $search = new SearchNostalgic();

        if ($appName == 'nostalgic'){
        $form = $this->createForm(YSearchType::class, $search);
        } elseif ($appName == 'yearinreview'){
            $form = $this->createForm(YSearchChannel::class, $search);

        }

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
//        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            if ($data->getPeriod()){
                $period = $data->getPeriod();
            } else {
                $period = "2019";
            }
            // ... perform some action, such as saving the data to the database
            try {
                $client = new Google_Client();
                $client->setApplicationName("yfilter");
                $client->setDeveloperKey($_ENV['YOUTUBE_APIKEY']);

                $service = new Google_Service_YouTube($client);

                if ($form->get('feeling_lucky')->isClicked()) {

                    $searchResult = $service->search->listSearch('id,snippet', array(
                        'q' => $data->getChannel(),
                        'maxResults' => '1',
                        'type' => 'channel'
                    ));

                    if(!isset($searchResult[0]['id'])){
                        setCookie('error','Sorry, we could not find any channels based on your search.');
                        return $this->redirectToRoute('homepage');
                    }

                    $userId = $searchResult['items'][0]['id']['channelId'];
                    return $this->redirect('/'. $appName .'/channel/' . $userId . '/period/' . $period);
                } else {

                    $searchResults = $service->search->listSearch('id,snippet', array(
                        'q' => $data->getChannel(),
                        'maxResults' => '12',
                        'type' => 'channel'
                    ));

                    if(!isset($searchResults[0]['id'])){
                        $this->throwError('Sorry, we could not find any channels based on your search.');
                        return $this->redirectToRoute('homepage');

                    }

                    return $this->render('nostalgic/channels.html.twig', array(
                        'results' => $searchResults,
                        'period' => $period,
                        'appName' => $appName
                    ));

                }

            } catch (Google_Exception $ge) {
                echo $ge;
            } catch (Google_Service_Exception $gse) {
                echo $gse;
            }

        }

        return $this->render('nostalgic/form/nostalgic.html.twig', array(
            'form' => $form->createView(),
        ));

    }
    private function throwError($string){
        $this->addFlash(
            'error',
            $string
        );
    }
}
