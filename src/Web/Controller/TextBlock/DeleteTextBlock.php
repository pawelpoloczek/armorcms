<?php

declare(strict_types=1);

namespace ArmorCMS\Web\Controller\TextBlock;

use ArmorCMS\TextBlock\Command\DeleteTextBlock as DeleteTextBlockCommand;
use ArmorCMS\TextBlock\Repository\TextBlockRepository;
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
final class DeleteTextBlock extends AbstractController
{
    use FlashMessageTrait;

    public function __construct(
        private readonly TextBlockRepository $textBlockRepository,
        private readonly MessageBusInterface $commandBus,
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route(
        'cms/textblock/delete/{uuid}',
        name: 'textblock_delete',
        requirements: ['uuid' => Requirement::UUID_V7],
        methods: [Request::METHOD_GET]
    )]
    public function __invoke(string $uuid, Request $request): Response
    {
        $textBlock = $this->textBlockRepository->findByUuid(Uuid::fromString($uuid));

        if (null === $textBlock) {
            $this->setFlashMessage($request, FlashMessageEnum::ERROR, $this->translator->trans('textblock.not_found'));

            return $this->redirectToRoute('web_textblock_get_list');
        }

        $this->commandBus->dispatch(
            new DeleteTextBlockCommand(Uuid::fromString($uuid))
        );

        $this->setFlashMessage($request, FlashMessageEnum::DONE, $this->translator->trans('textblock.delete_success'));
        return $this->redirectToRoute('web_textblock_get_list');
    }
}
