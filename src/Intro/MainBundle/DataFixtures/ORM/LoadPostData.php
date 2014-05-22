<?php

namespace Intro\MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Intro\MainBundle\DataFixtures\ORM\LoadIntroData;
use Intro\MainBundle\Entity\Post as Post;

class LoadPostData extends LoadIntroData implements OrderedFixtureInterface
{
    /**
     * Main load function.
     *
     * @param Doctrine\Common\Persistence\ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $posts = $this->getModelFixtures();

        // Now iterate thought all fixtures
        foreach ($posts['Post'] as $reference => $columns)
        {
            $post = new Post();
            $post->setTitle($columns['title']);
            $post->setBody($columns['body']);
            $post->setCreated($columns['created']);
            $post->setUpdated($columns['updated']);
            $post->setStatus($columns['status']);
//            $post->setRole($manager->merge($this->getReference('Post_' . $columns['role'])));
            
            $manager->persist($post);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('Post_'. $reference, $post);
        }
        $manager->flush();
    }

    /**
     * The main fixtures file for this loader.
     */
    public function getModelFile()
    {
        return 'posts';
    }

    /**
     * The order in which these fixtures will be loaded.
     */
    public function getOrder()
    {
        return 1;
    }
}
