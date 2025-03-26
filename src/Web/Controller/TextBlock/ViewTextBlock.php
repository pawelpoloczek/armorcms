<?php

declare(strict_types=1);

namespace ArmorCMS\Web\Controller\TextBlock;

use ArmorCMS\Page\Repository\PageRepository;
use ArmorCMS\Shared\Exception\EntityNotFound;
use ArmorCMS\TextBlock\Repository\TextBlockRepository;
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
final class ViewTextBlock extends AbstractController
{
    use FlashMessageTrait;

    public function __construct(
        private readonly TextBlockRepository $textBlockRepository,
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route(
        '/cms/textblock/view/{uuid}',
        name: 'textblock_view',
        requirements: ['uuid' => Requirement::UUID_V7],
        methods: [Request::METHOD_GET]
    )]
    public function __invoke(
        string $uuid,
        Request $request
    ): Response {
        try {
            $textblock = $this->textBlockRepository->getForPreview(Uuid::fromString($uuid));
        } catch (EntityNotFound) {
            $this->setFlashMessage(
                $request,
                FlashMessageEnum::ERROR,
                $this->translator->trans('textblock.not_found')
            );

            return $this->redirectToRoute('web_textblock_get_list');
        }

        return $this->render('TextBlock/textblock_view.html.twig', [
            'textblock' => $textblock,
        ]);
    }
}
