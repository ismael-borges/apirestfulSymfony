<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Request;

class ExtratorDadosRequest
{
    private function buscaDadosRequest(Request $request)
    {
        $queryString = $request->query->all();
        $ordenacao = array_key_exists('ordenacao', $queryString) ? $queryString['ordenacao'] : null;
        $pagina = array_key_exists('pagina', $queryString) ? $queryString['pagina'] : 1;
        $limite = array_key_exists('limite', $queryString) ? $queryString['limite'] : 3;

        unset($queryString['ordenacao']);
        unset($queryString['pagina']);
        unset($queryString['limite']);

        return [$queryString, $ordenacao, $limite, $pagina];
    }

    public function buscaDadosOrdenacao(Request $request)
    {
        [, $ordenacao] = $this->buscaDadosRequest($request);
        return $ordenacao;
    }

    public function buscaDadosDeFiltro(Request $request)
    {
        [$filtro, ] = $this->buscaDadosRequest($request);
        return $filtro;
    }

    public function buscaDadosPorPaginacao(Request $request)
    {
        [, , $limite, $pagina] = $this->buscaDadosRequest($request);
        return [$limite, $pagina];
    }
}