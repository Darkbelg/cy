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
     * @Route("/", name="homepage_nostalgic_channels", host="www.nostalgicchannels.com")
     */
    public function nostalgicChannelsHomepage()
    {
/*        echo "nostalgic";
        echo "<pre>";
        var_dump($_SERVER);
        echo "</pre>";*/

        $searchNostalgic = new SearchNostalgic();

        $formNostalgic = $this->createForm(YSearchType::class, $searchNostalgic, array(
            'action' => '/search/nostalgic'
        ));

        return $this->render('nostalgic/form/nostalgic.html.twig', array(
            'formNostalgic' => $formNostalgic->createView()
        ));
    }

    /**
     * @Route("/", name="homepage_year_in_review_channnels")
     */
    public function yearInReviewChannelsHomepage()
    {
/*        echo "yearinreview";
    echo "<pre>";
    var_dump($_SERVER);
    echo "</pre>";*/

        $searchNostalgic = new SearchNostalgic();

        $formYearInReview = $this->createForm(YSearchChannel::class, $searchNostalgic, array(
            'action' => '/search/yearinreview'
        ));

        return $this->render('nostalgic/form/nostalgic.html.twig', array(
            'formYearInReview' => $formYearInReview->createView()
        ));
    }
}
