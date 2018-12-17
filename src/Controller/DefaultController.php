<?php


namespace App\Controller;

use App\Entity\SearchNostalgic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $searchNostalgic = new SearchNostalgic();

        $form = $this->createFormBuilder($searchNostalgic,
            array(
            'action' => '/nostalgic'
            ))
            ->add('channelId', TextType::class, array('label' => 'Name'))
            ->add('search',SubmitType::class, array('label' => 'Search'))
            ->getForm();

        return $this->render('nostalgic/form/nostalgic.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
