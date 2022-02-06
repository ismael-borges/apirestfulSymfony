<?php

namespace App\Controller;

use App\Entity\Especialidade;
use App\Helper\EspecialidadeFactory;
use App\Helper\ExtratorDadosRequest;
use App\Repository\EspecialidadeRepository;
use Doctrine\ORM\EntityManagerInterface;

class EspecialidadesController extends BaseController
{
    public function __construct(
        EntityManagerInterface $entityManager,
        EspecialidadeRepository $especialidadeRepository,
        EspecialidadeFactory $especialidadeFactory,
        ExtratorDadosRequest $extratorDadosRequest
    ) {
        parent::__construct(
            $especialidadeRepository,
            $entityManager,
            $especialidadeFactory,
            $extratorDadosRequest
        );
    }

    /**
     * @param Especialidade $content
     * @param Especialidade $entity
     */
    public function atualizarEntity($id, $content)
    {
        $entity = $this->repository->find($id);

        if (is_null($entity)) {
            throw new \InvalidArgumentException();
        }

        $entity->setDescricao($content->getDescricao());
        return $entity;
    }
}
