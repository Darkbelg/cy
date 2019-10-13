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

    public function nostalgicChannelsHomepage(): \Symfony\Component\HttpFoundation\Response
    {

        $searchNostalgic = new SearchNostalgic();

        $formNostalgic = $this->createForm(YSearchType::class, $searchNostalgic, array(
            'action' => '/search/nostalgic'
        ));

        return $this->render('nostalgic/form/nostalgic.html.twig', array(
            'formNostalgic' => $formNostalgic->createView()
        ));
    }

    public function yearInReviewChannelsHomepage(): \Symfony\Component\HttpFoundation\Response
    {

        $searchNostalgic = new SearchNostalgic();

        $formYearInReview = $this->createForm(YSearchChannel::class, $searchNostalgic, array(
            'action' => '/search/yearinreview'
        ));

        return $this->render('year_in_review/form/yearinreview.html.twig', array(
            'formYearInReview' => $formYearInReview->createView()
        ));
    }

    /**
     * @Route("/", name="homepage")
     */
    public function hostController()
    {
        $domain = $_COOKIE['domain'];
        switch ($domain){
            case 'www.nostalgicchannels.com':
                return $this->nostalgicChannelsHomepage();
            break;
            case 'www.yearinreviewchannels.com':
                return $this->yearInReviewChannelsHomepage();
            default:
                $domainScript = <<< script
<script>
    document.cookie = "domain=" + window.location.hostname;
    location.reload();
</script>
script;
            echo $domainScript;
        }
    }
}
