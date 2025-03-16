<?php

declare(strict_types=1);

namespace ArmorCMS\Web\Controller\Page;

use ArmorCMS\Page\Repository\PageRepository;
use ArmorCMS\Shared\Exception\EntityNotFound;
use ArmorCMS\Web\Enum\FlashMessageEnum;
use ArmorCMS\Web\Trait\FlashMessageTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(name: 'web_')]
final class ViewPage extends AbstractController
{
    use FlashMessageTrait;

    public function __construct(
        private readonly PageRepository $pageRepository,
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route(
        '/cms/pages/view/{uuid}',
        name: 'page_view',
        requirements: ['uuid' => Requirement::UUID_V7],
        methods: [Request::METHOD_GET]
    )]
    public function __invoke(
        string $uuid,
        Request $request
    ): Response {
        try {
        $page = $this->pageRepository->getForPreview(Uuid::fromString($uuid));
        } catch (EntityNotFound) {
            $this->setFlashMessage(
                $request,
                FlashMessageEnum::ERROR,
                $this->translator->trans('page.not_found')
            );

            return $this->redirectToRoute('web_page_get_list');
        }

        return $this->render('Page/page_view.html.twig', [
            'page' => $page,
        ]);
    }
}
