<?php

namespace App\Repository;

use App\Entity\Account;
use Doctrine\Persistence\ManagerRegistry;

class AccountRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }
}
