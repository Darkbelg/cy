<?php


namespace App\Controller;

use App\Entity\SearchNostalgic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NostalgicController extends AbstractController
{
    /**
     * @Route("/nostalgic", name="nostalgic_search")
     */
    public function search(Request $request)
    {
        $searchNostalgic = new SearchNostalgic();

        $form = $this->createFormBuilder($searchNostalgic,
            array(
                'action' => '/nostalgic'
            ))
            ->add('channelId', TextType::class, array('label' => 'Name'))
            ->add('search',SubmitType::class, array('label' => 'Search'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();


            // ... perform some action, such as saving the data to the database

//            return $this->redirectToRoute('task_success');
        }

        return $this->render('nostalgic/form/nostalgic.html.twig', array(
            'form' => $form->createView(),
        ));

    }

}