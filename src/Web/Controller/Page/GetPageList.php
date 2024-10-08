<?php

declare(strict_types=1);

namespace ArmorCMS\Web\Controller\Page;

use ArmorCMS\Page\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'web_')]
final class GetPageList extends AbstractController
{
    public function __construct(
        private readonly PageRepository $pageRepository
    ) {
    }

    #[Route(
        '/cms/pages',
        name: 'page_get_list',
        methods: [Request::METHOD_GET]
    )]
    public function __invoke(): Response
    {
        return $this->render('Page/page_index.html.twig', [
            'pages' => $this->pageRepository->findAllIterable(),
        ]);
    }
}
