<?php

namespace App\Request\Dashboard;

use App\Entity\Account;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;

class DashboardRequest
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getCurrentUser(): User
    {
        return $this->security->getUser();
    }
}
