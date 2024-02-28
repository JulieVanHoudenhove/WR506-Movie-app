<?php

namespace App\EventSubscriber;

use App\Entity\Movie;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;

class MovieEventSubscriber implements EventSubscriber
{
    public function __construct(protected Security $security)
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $movie = $args->getObject();

        if ($movie instanceof Movie && $movie->getUser() === null) {
            $user = $this->security->getUser();
            $movie->setUser($user);
        }
    }
}
