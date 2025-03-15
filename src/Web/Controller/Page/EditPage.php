<?php

declare(strict_types=1);

namespace ArmorCMS\Web\Controller\Page;

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
final class EditPage extends AbstractController
{
    use FlashMessageTrait;

    public function __construct(
        private readonly PageRepository $pageRepository,
        private readonly MessageBusInterface $commandBus,
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route(
        '/cms/pages/edit/{uuid}',
        name: 'page_edit',
        requirements: ['uuid' => Requirement::UUID_V7],
        methods: [Request::METHOD_GET, Request::METHOD_POST]
    )]
    public function __invoke(
        string $uuid,
        Request $request
    ): Response {
        $pageUuid = Uuid::fromString($uuid);
        $page = $this->pageRepository->findByUuid($$pageUuid);
        if (null === $$page) {
            $this->setFlashMessage(
                $request,
                FlashMessageEnum::ERROR,
                $this->translator->trans('page.not_found')
            );

            return $this->redirectToRoute('web_page_get_list');
        }

        // $form = $this->createForm(
        //     EditUserType::class,
        //     [
        //         'email' => $user->getEmail(),
        //         'isAdmin' => $user->isAdmin(),
        //     ]
        // );
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $this->commandBus->dispatch(
        //         new UpdateUser(
        //             $userUuid,
        //             $form->getData()['email'],
        //             $form->getData()['isAdmin'],
        //             $form->getData()['avatar']
        //         )
        //     );

        //     $this->setFlashMessage(
        //         $request,
        //         FlashMessageEnum::DONE,
        //         $this->translator->trans('user.edit_success')
        //     );

        //     return $this->redirectToRoute('web_user_view', ['uuid' => $userUuid]);
        // }

        return $this->render('Page/page_edit.html.twig', [
            // 'form' => $form->createView(),
        ]);
    }
}
