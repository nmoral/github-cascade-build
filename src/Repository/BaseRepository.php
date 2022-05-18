<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class BaseRepository extends ServiceEntityRepository
{
    public function persist($object): void
    {
        $this->_em->persist($object);
    }

    public function flush(): void
    {
        $this->_em->flush();
    }
}
