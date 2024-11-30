<?php
declare(strict_types=1);

namespace ArmorCMS\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardGet extends AbstractController
{
    #[Route(
        '/',
        name: 'dashboard',
        methods: [Request::METHOD_GET]
    )]
    public function __invoke(): Response
    {
        return $this->render('dashboard.html.twig', [
//            'lastLoggedUsers' => $lastLoggedUsers,
//            'memoryInfo' => $this->systemInfoService->getMemoryInfo(),
//            'cpuInfo' => $this->systemInfoService->getCPUInfo(),
        ]);
    }
}
