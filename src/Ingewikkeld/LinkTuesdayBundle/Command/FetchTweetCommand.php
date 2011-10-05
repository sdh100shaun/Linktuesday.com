<?php

namespace Ingewikkeld\LinkTuesdayBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Bundle\FrameworkBundle\Util\Mustache;

use Zend\Service\Twitter\Search;

use Ingewikkeld\LinkTuesdayBundle\Entity\Link;
use Ingewikkeld\LinkTuesdayBundle\Entity\Tweet;

/**
 * Fetches new tweets from twitter
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class FetchTweetCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setDefinition(array(
                ))
            ->setHelp(<<<EOT
The <info>linktuesday:fetchtweet</info> command fetches and parses new tweets looking for new links to index

<info>./app/console linktuesday:fetchtweet</info>
EOT
            )
            ->setName('linktuesday:fetchtweet')
        ;
    }

    /**
     * @see Command
     *
     * @throws \InvalidArgumentException When namespace doesn't end with Bundle
     * @throws \RuntimeException         When bundle can't be executed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $search = new Search();

        $results = $search->search('#linktuesday', array('lang' => 'en'));
        foreach($results->results as $result)
        {
            $uri = '';
            $parts = explode(' ', $result->text);
            foreach($parts as $part)
            {
                if (substr($part, 0, 7) == 'http://')
                {
                    $uri = $part;
                }
            }

            if (!empty($uri))
            {

                $link = new Link();
                $link->setUri($uri);

                $existing = $em->getRepository('IngewikkeldLinkTuesdayBundle:Link')->getByFullUri($link->getFullUri());
                if ($existing)
                {
                    $link = $existing;
                }

                if ($link->getId() < 1)
                {
                    $em->persist($link);
                }

                $tweetDate = new \DateTime($result->created_at);

                $existingTweet = $em->getRepository('IngewikkeldLinkTuesdayBundle:Tweet')->findOneBy(array(
                    'date' => $tweetDate->format('Y-m-d G:i:s'),
                    'user' => $result->from_user,
                    'content' => $result->text,
                ));

                if (!$existingTweet)
                {
                    $tweet = new Tweet();
                    $tweet->setContent($result->text);
                    $tweet->setLink($link);
                    $tweet->setDate(new \DateTime($result->created_at));
                    $tweet->setProfileImage($result->profile_image_url);
                    $tweet->setUser($result->from_user);
                    $tweet->setUri('test');

                    $em->persist($tweet);
                }
                
                $em->flush();
            }
        }
    }
}
