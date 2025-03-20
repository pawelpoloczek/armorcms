<?php

declare(strict_types=1);

namespace ArmorCMS\Web\Controller\TextBlock;

use ArmorCMS\TextBlock\Repository\TextBlockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(name: 'web_')]
final class GetTextBlockList extends AbstractController
{
    public function __construct(
        private readonly TextBlockRepository $textBlockRepository
    ) {
    }

    #[Route(
        '/cms/textblock',
        name: 'textblock_get_list',
        methods: [Request::METHOD_GET]
    )]
    public function __invoke(): Response
    {
        return $this->render('TextBlock/textblock_index.html.twig', [
            'textBlocks' => $this->textBlockRepository->findAllIterable(),
        ]);
    }
}
