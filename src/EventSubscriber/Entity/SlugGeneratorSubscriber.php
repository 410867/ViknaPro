<?php

namespace App\EventSubscriber\Entity;

use App\Entity\SluggerEntityInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsDoctrineListener(event: Events::preUpdate)]
#[AsDoctrineListener(event: Events::postPersist)]
final class SlugGeneratorSubscriber
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function preUpdate(LifecycleEventArgs $event): void
    {
        $entity = $event->getObject();
        if (!$entity instanceof SluggerEntityInterface) {
            return;
        }
        if ($entity->getSlug()) {
            return;
        }

        $entity->setSlug(
            strtolower($this->slugger->slug($entity->getTitle() . '-' . $entity->getId()))
        );
    }

    public function postPersist(LifecycleEventArgs $event): void
    {
        $entity = $event->getObject();
        if (!$entity instanceof SluggerEntityInterface) {
            return;
        }
        if ($entity->getSlug()) {
            return;
        }

        $entity->setSlug(
            strtolower($this->slugger->slug($entity->getTitle() . '-' . $entity->getId()))
        );
        $event->getObjectManager()->flush();
    }
}