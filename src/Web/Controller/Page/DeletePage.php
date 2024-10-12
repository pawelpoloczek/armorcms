<?php

declare(strict_types=1);

namespace ArmorCMS\Web\Controller\Page;

use ArmorCMS\Page\Command\DeletePage as DeletePageCommand;
use ArmorCMS\Page\Repository\PageRepository;
use ArmorCMS\Web\Enum\FlashMessageEnum;
use ArmorCMS\Web\Trait\FlashMessageTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(name: 'web_')]
final class DeletePage extends AbstractController
{
    use FlashMessageTrait;

    public function __construct(
        private readonly PageRepository $pageRepository,
        private readonly MessageBusInterface $commandBus,
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route(
        'cms/pages/delete/{uuid}',
        name: 'page_delete',
        requirements: ['uuid' => Requirement::UUID_V7],
        methods: [Request::METHOD_GET]
    )]
    public function __invoke(string $uuid, Request $request): Response
    {
        $page = $this->pageRepository->findByUuid(Uuid::fromString($uuid));

        if (null === $page) {
            $this->setFlashMessage($request, FlashMessageEnum::ERROR, $this->translator->trans('page.not_found'));

            return $this->redirectToRoute('web_page_get_list');
        }

        $this->commandBus->dispatch(
            new DeletePageCommand(Uuid::fromString($uuid))
        );

        $this->setFlashMessage($request, FlashMessageEnum::DONE, $this->translator->trans('page.delete_success'));
        return $this->redirectToRoute('web_page_get_list');
    }
}
