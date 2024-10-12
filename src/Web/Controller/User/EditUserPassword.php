<?php
declare(strict_types=1);

namespace ArmorCMS\Web\Controller\User;

use ArmorCMS\User\Command\UpdateUserPassword;
use ArmorCMS\User\Repository\UserRepository;
use ArmorCMS\Web\Enum\FlashMessageEnum;
use ArmorCMS\Web\Form\User\EditUserPasswordType;
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
final class EditUserPassword extends AbstractController
{
    use FlashMessageTrait;

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly MessageBusInterface $commandBus,
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route(
        '/settings/users/edit/{uuid}/password',
        name: 'user_edit_password',
        requirements: ['uuid' => Requirement::UUID_V7],
        methods: [Request::METHOD_GET, Request::METHOD_POST]
    )]
    public function __invoke(
        string $uuid,
        Request $request
    ): Response {
        $userUuid = Uuid::fromString($uuid);
        $user = $this->userRepository->findByUuid($userUuid);
        if (null === $user) {
            $this->setFlashMessage(
                $request,
                FlashMessageEnum::ERROR,
                $this->translator->trans('user.not_found')
            );

            return $this->redirectToRoute('web_user_get_list');
        }

        $form = $this->createForm(
            EditUserPasswordType::class,
            [],
            ['userUuid' => $userUuid]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->dispatch(
                new UpdateUserPassword(
                    $userUuid,
                    $form->getData()['newPassword']
                )
            );

            $this->setFlashMessage(
                $request,
                FlashMessageEnum::DONE,
                $this->translator->trans('user.edit_password_success')
            );

            return $this->redirectToRoute('web_user_view', ['uuid' => $userUuid]);
        }

        return $this->render('User/user_edit_password.html.twig', [
            'formEditPassword' => $form->createView(),
        ]);
    }
}
