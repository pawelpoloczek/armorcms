<?php

declare(strict_types=1);

namespace ArmorCMS\Web\Controller\TextBlock;

use ArmorCMS\TextBlock\Command\CreateTextBlock as CreateTextBlockCommand;
use ArmorCMS\Web\Enum\FlashMessageEnum;
use ArmorCMS\Web\Form\TextBlock\CreateTextBlockType;
use ArmorCMS\Web\Trait\FlashMessageTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Factory\UuidFactory;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(name: 'web_')]
final class CreateTextBlock extends AbstractController
{
    use FlashMessageTrait;

    public function __construct(
        private readonly UuidFactory $uuidFactory,
        private readonly MessageBusInterface $commandBus,
        private readonly TranslatorInterface $translator
    ) {}

    #[Route(
        '/cms/textblock/create',
        name: 'textblock_create',
        methods: [Request::METHOD_GET, Request::METHOD_POST]
    )]
    public function __invoke(
        Request $request
    ): Response {
        $form = $this->createForm(CreateTextBlockType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $textblockUuid = $this->uuidFactory->create();

            $this->commandBus->dispatch(
                new CreateTextBlockCommand(
                    $textblockUuid,
                    $form->getData()['blockKey'],
                    $form->getData()['isActive'],
                    $form->getData()['content'],
                    $form->getData()['description'],
                )
            );

            $this->setFlashMessage(
                $request,
                FlashMessageEnum::DONE,
                $this->translator->trans('textblock.add_success')
            );

            return $this->redirectToRoute('web_textblock_get_list');
        }

        return $this->render('TextBlock/textblock_create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
