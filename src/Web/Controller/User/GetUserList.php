<?php

declare(strict_types=1);

namespace ArmorCMS\Web\Controller\User;

use ArmorCMS\User\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(name: 'web_')]
final class GetUserList extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    #[Route(
        '/settings/users',
        name: 'user_get_list',
        methods: [Request::METHOD_GET]
    )]
    public function __invoke(): Response
    {
        return $this->render('User/user_index.html.twig', [
            'users' => $this->userRepository->findAllIterable(),
        ]);
    }
}
