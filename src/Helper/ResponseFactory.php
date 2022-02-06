<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseFactory
{
    public function __construct(
        private bool $sucesso,
        private int $statusresposta,
        private ?int $pagina,
        private ?int $itensPorPagina,
        private $conteudo
    ) {}

    public function getResponse(): JsonResponse
    {
        $resposta = [
            'sucesso' => $this->sucesso,
            'pagina' => $this->pagina,
            'itensPorPagina' => $this->itensPorPagina,
            'conteudo' => $this->conteudo,
        ];

        if (is_null($resposta['pagina'])) {
            unset($resposta['pagina']);
            unset($resposta['itensPorPagina']);
        }
        return new JsonResponse($resposta, $this->statusresposta);
    }
}