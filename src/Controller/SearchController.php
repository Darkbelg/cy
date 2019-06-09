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

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request)
    {
        $search = new SearchNostalgic();

        $form = $this->createForm(YSearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
//        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
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
                        $this->throwError('Sorry, we could not find any channels based on your search.');
                        return $this->redirectToRoute('homepage');
                    }

                    $userId = $searchResult['items'][0]['id']['channelId'];
                    return $this->redirect('/nostalgic/channel/' . $userId . '/period/' . $data->getPeriod());
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
                        'period' => $data->getPeriod()
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
