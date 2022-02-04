<?php

namespace App\Helper;

use App\Entity\Medico;
use App\Repository\EspecialidadeRepository;

class MedicoFactory implements EntidadeFactory
{
    private EspecialidadeRepository $especialidadeRepository;

    public function __construct(EspecialidadeRepository $especialidadeRepository)
    {
        $this->especialidadeRepository = $especialidadeRepository;
    }

    public function criarEntidade(string $json): Medico
    {
        $data = json_decode($json);
        $medico = new Medico();
        $medico->setCrm($data->crm)
            ->setNome($data->nome)
            ->setEspecialidade(
                $this->especialidadeRepository->find($data->especialidadeId)
            );

        return $medico;
    }
}