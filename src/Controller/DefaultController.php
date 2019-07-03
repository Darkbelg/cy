<?php


namespace App\Controller;

use App\Entity\SearchNostalgic;
use App\Form\YSearchChannel;
use App\Form\YSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $searchNostalgic = new SearchNostalgic();

        $formNostalgic = $this->createForm(YSearchType::class, $searchNostalgic, array(
            'action' => '/search/nostalgic'
        ));

        $formYearInReview = $this->createForm(YSearchChannel::class, $searchNostalgic, array(
            'action' => '/search/yearinreview'
        ));

/*        if (isset($_COOKIE["error"])) {
            $error = $_COOKIE["error"];
            unset($_COOKIE["error"]);
            setcookie('error', '', time() - 3600, '/');
            return $this->render('nostalgic/form/nostalgic.html.twig', array(
                'form' => $form->createView(),'error' => $error
            ));
        }*/

        return $this->render('nostalgic/form/nostalgic.html.twig', array(
            'formNostalgic' => $formNostalgic->createView(),
            'formYearInReview' => $formYearInReview->createView()
        ));
    }
}
