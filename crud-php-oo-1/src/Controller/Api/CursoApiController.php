<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\CursoRepository;

class CursoApiController
{
    public function getAll(): void
    {
        $rep = new CursoRepository();
        $cursos = $rep->buscarTodos();
        echo json_encode($cursos);
    }
}
