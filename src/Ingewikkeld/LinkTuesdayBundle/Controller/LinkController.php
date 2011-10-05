<?php

namespace Ingewikkeld\LinkTuesdayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LinkController extends Controller
{
    /**
     * @extra:Route("/", name="lt_homepage")
     * @extra:Template()
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        return array(
            'recent'    => $em->getRepository('IngewikkeldLinkTuesdayBundle:Link')->getMostRecentLinks(),
            'top'       => $em->getRepository('IngewikkeldLinkTuesdayBundle:Link')->getMostPopularLinks(),
            'weektop'   => $em->getRepository('IngewikkeldLinkTuesdayBundle:Link')->getMostPopularLinksSince(date('d-m-Y', time()-(86400*7))),
        );
    }

    /**
     * @extra:Route("/feed", name="lt_feed")
     * @extra:Template()
     */
    public function rssAction()
    {
      $em = $this->get('doctrine.orm.default_entity_manager');

      $items = $em->getRepository('IngewikkeldLinkTuesdayBundle:Link')->getMostRecentLinks();

      $templateItems = array();
      foreach($items as $item)
      {
        $templateItems[] = $item[0];
      }

      return array('items' => $templateItems, 'date' => date('c'));
    }
}
