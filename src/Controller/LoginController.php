<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    private UserRepository $repository;
    private UserPasswordHasherInterface $encoder;

    public function __construct(
        UserRepository $repository,
        UserPasswordHasherInterface $encoder
    ) {
        $this->repository = $repository;
        $this->encoder = $encoder;
    }

    #[Route('/login', name: 'login')]
    public function index(Request $request): Response
    {
        $dadaosEmJson = json_decode($request->getContent());

        if (is_null($dadaosEmJson->uuid) || is_null($dadaosEmJson->password)) {
            return new JsonResponse(
                ["Error" => "Favor enviar dados válidos para autenticação"],
                Response::HTTP_BAD_REQUEST);
        }

        $usuario = $this->repository->findOneBy([
            "uuid" => $dadaosEmJson->uuid
        ]);

        if(!$this->encoder->isPasswordValid($usuario, $dadaosEmJson->password)) {
            return new JsonResponse(
                ["Error" => "Usuário ou senha inválido"],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $token = JWT::encode(
            ["uuid" => $usuario->getUuid()],
            "D3V!@#",
            "HS256"
        );

        return new JsonResponse([
            "access_token" => $token
        ]);
    }
}
