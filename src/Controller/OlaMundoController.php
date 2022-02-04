<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OlaMundoController
{
    /**
     * @Route("/ola")
     */
    public function olaMundoAction(Request $request): Response
    {
        return new JsonResponse([
            "mensagem" => "Olá Mundo",
            "pathInfo" => $request->getPathInfo(),
            "parametro" => $request->query->get("parametro"),
            "query" => $request->query->all()
        ]);
    }
}