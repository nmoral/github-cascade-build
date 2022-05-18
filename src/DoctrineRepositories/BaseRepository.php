<?php

namespace App\DoctrineRepositories;

use App\Entity\BaseEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class BaseRepository extends ServiceEntityRepository
{
    public function persist(BaseEntity $object): void
    {
        if (!$object->shouldBePersisted()) {
            return;
        }
        $this->_em->persist($object);
    }

    public function flush(): void
    {
        $this->_em->flush();
    }
}
