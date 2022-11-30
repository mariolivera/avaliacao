<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\ProfessorRepository;

class AlunoApiController
{
    public function getAll(): void
    {
        $rep = new ProfessorRepository;
        $professores = $rep->buscarTodos();
        echo json_encode($professores);
    }
}
