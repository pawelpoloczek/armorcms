<?php

declare(strict_types=1);

namespace ArmorCMS\Web\Controller\Page;

use ArmorCMS\Page\Command\CreatePage as CreatePageCommand;
use ArmorCMS\Page\DTO\CreateSeo;
use ArmorCMS\Web\Enum\FlashMessageEnum;
use ArmorCMS\Web\Form\Page\CreatePageType;
use ArmorCMS\Web\Trait\FlashMessageTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Factory\UuidFactory;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(name: 'web_')]
final class CreatePage extends AbstractController
{
    use FlashMessageTrait;

    public function __construct(
        private readonly UuidFactory $uuidFactory,
        private readonly MessageBusInterface $commandBus,
        private readonly TranslatorInterface $translator
    ) {}

    #[Route(
        '/cms/pages/create',
        name: 'page_create',
        methods: [Request::METHOD_GET, Request::METHOD_POST]
    )]
    public function __invoke(
        Request $request
    ): Response {
        $form = $this->createForm(CreatePageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pageUuid = $this->uuidFactory->create();

            $this->commandBus->dispatch(
                new CreatePageCommand(
                    $pageUuid,
                    $form->getData()['title'],
                    $form->getData()['slug'],
                    $form->getData()['isActive'],
                    $form->getData()['author'],
                    $form->getData()['content'],
                    new CreateSeo(
                        $this->uuidFactory->create(),
                        $form->getData()['seoTitle'],
                        $form->getData()['seoDescription'],
                        $form->getData()['robots'],
                        $form->getData()['seoOgTitle'],
                        $form->getData()['seoOgDescription'],
                        $form->getData()['seoOgSection'],
                        $form->getData()['seoOgTags']
                    )
                )
            );

            $this->setFlashMessage(
                $request,
                FlashMessageEnum::DONE,
                $this->translator->trans('page.add_success')
            );

            return $this->redirectToRoute('web_page_get_list');
        }

        return $this->render('Page/page_create.html.twig', [
            'formPage' => $form->createView(),
        ]);
    }
}
