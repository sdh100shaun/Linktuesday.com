<?php

namespace Ingewikkeld\LinkTuesdayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class LinkController extends Controller
{
    /**
     * @Route("/", name="lt_homepage")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->get('doctrine');

        return array(
            'recent'    => $em->getRepository('IngewikkeldLinkTuesdayBundle:Link')->getMostRecentLinks(),
            'top'       => $em->getRepository('IngewikkeldLinkTuesdayBundle:Link')->getMostPopularLinks(),
            'weektop'   => $em->getRepository('IngewikkeldLinkTuesdayBundle:Link')->getMostPopularLinksSince(date('d-m-Y', time()-(86400*7))),
        );
    }

    /**
     * @Route("/feed", name="lt_feed")
     * @Template()
     */
    public function rssAction()
    {
      $em = $this->get('doctrine');

      $items = $em->getRepository('IngewikkeldLinkTuesdayBundle:Link')->getMostRecentLinks();

      $templateItems = array();
      foreach($items as $item)
      {
        $templateItems[] = $item[0];
      }

      return array('items' => $templateItems, 'date' => date('c'));
    }
}
