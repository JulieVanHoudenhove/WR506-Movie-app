<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class MeController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    #[Route("/api/me", name:"get_current_user", methods:["GET"])]
    public function getCurrentUser(UserInterface $user): JsonResponse
    {
        $userData = [
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
        ];

        return new JsonResponse($userData);
    }
    #[Route("/api/me/update", name:"update_current_user", methods:["POST"])]
    public function updateCurrentUser(UserInterface $user, Request $request): JsonResponse
    {
        $email = $request->request->get('email');
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        if ($email) {
            $user->setEmail($email);
        }

        if ($password) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        }
        if ($username) {
            $user->setUsername($username);
        }

        $this->em->flush();

        return new JsonResponse('Utilisateur mis à jour avec succès !');
    }
}