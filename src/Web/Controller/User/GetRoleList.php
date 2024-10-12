<?php

declare(strict_types=1);

namespace ArmorCMS\Web\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(name: 'web_')]
final class GetRoleList extends AbstractController
{
    #[Route(
        '/settings/roles',
        name: 'role_get_list',
        methods: [Request::METHOD_GET]
    )]
    public function __invoke(): Response
    {
        return $this->render('User/role_index.html.twig', [
            'roles' => [
                [
                    'key' => 'ROLE_USER',
                    'name' => 'Użytkownik',
                    'description' => '',
                ],
                [
                    'key' => 'ROLE_ADMIN',
                    'name' => 'Administrator',
                    'description' => '',
                ],
                [
                    'key' => 'ROLE_ROOT',
                    'name' => 'Główny administrator',
                    'description' => '',
                ],
            ],
        ]);
    }
}
