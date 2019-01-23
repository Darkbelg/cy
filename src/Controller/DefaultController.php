<?php


namespace App\Controller;

use App\Entity\SearchNostalgic;
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

        $form = $this->createForm(YSearchType::class,$searchNostalgic, array(
            'action' => '/search'
        ));

        return $this->render('nostalgic/form/nostalgic.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
