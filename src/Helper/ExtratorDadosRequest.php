<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Request;

class ExtratorDadosRequest
{
    private function getDataRequest(Request $request)
    {
        $queryString = $request->query->all();
        $sort = $queryString['sort'];
        unset($queryString['sort']);

        return [$sort, $queryString];
    }

    public function getDataSort(Request $request)
    {
        [$order,] = $this->getDataRequest($request);
        return $order;
    }

    public function getDataFilter(Request $request)
    {
        [, $filters] = $this->getDataRequest($request);
        return $filters;
    }
}