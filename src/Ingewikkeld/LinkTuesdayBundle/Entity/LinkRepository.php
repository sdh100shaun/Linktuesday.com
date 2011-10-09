<?php

namespace Ingewikkeld\LinkTuesdayBundle\Entity;

use Doctrine\ORM\EntityRepository;

class LinkRepository extends EntityRepository
{
    public function getMostRecentLinks()
    {
        return $this->_em->createQuery('SELECT l, COUNT(t.id) AS tweetCount FROM IngewikkeldLinkTuesdayBundle:Link l LEFT JOIN l.tweets t GROUP BY l.id ORDER BY l.id DESC')->setMaxResults(10)->getResult();
    }

    public function getMostPopularLinks()
    {
        return $this->_em->createQuery('SELECT l, COUNT(t.id) AS tweetCount FROM IngewikkeldLinkTuesdayBundle:Link l LEFT JOIN l.tweets t GROUP BY l.full_uri ORDER BY tweetCount DESC')->setMaxResults(10)->getResult();

    }

    public function getByFullUri($fullUri)
    {
        $result = $this->_em->createQuery("SELECT l FROM IngewikkeldLinkTuesdayBundle:Link l WHERE l.full_uri = :full_uri")->setParameter('full_uri', $fullUri)->getResult();
        if(isset($result[0]))
        {
          return $result[0];
        }
    }

    public function getMostPopularLinksSince($since)
    {
        $date = new \DateTime($since);
        return $this->_em->createQuery('SELECT l, COUNT(t.id) AS tweetCount FROM IngewikkeldLinkTuesdayBundle:Link l LEFT JOIN l.tweets t WHERE t.date >= \''.$date->format('Y-m-d G:i:s').'\' GROUP BY l.full_uri ORDER BY tweetCount DESC')->setMaxResults(10)->getResult();
    }
}