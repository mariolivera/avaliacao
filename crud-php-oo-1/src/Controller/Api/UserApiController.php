<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\UserRepository;

class UserApiController
{
    public function getAll()
    {
        $rep = new UserRepository();

        echo json_encode($rep->findAll());
    }
}
