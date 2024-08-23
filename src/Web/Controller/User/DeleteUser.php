<?php

declare(strict_types=1);

namespace ArmorCMS\Web\Controller\User;

use ArmorCMS\User\Command\DeleteUser as DeleteUserCommand;
use ArmorCMS\User\Repository\UserRepository;
use ArmorCMS\Web\Enum\FlashMessageEnum;
use ArmorCMS\Web\Trait\FlashMessageTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(name: 'web_')]
final class DeleteUser extends AbstractController
{
    use FlashMessageTrait;

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly MessageBusInterface $commandBus,
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route(
        'settings/users/{uuid}',
        name: 'user_delete',
        requirements: ['uuid' => Requirement::UUID_V7],
        methods: [Request::METHOD_GET]
    )]
    public function __invoke(string $uuid, Request $request): Response
    {
        $user = $this->userRepository->findByUuid(Uuid::fromString($uuid));

        if (null === $user) {
            $this->setFlashMessage($request, FlashMessageEnum::ERROR, $this->translator->trans('user.not_found'));

            return $this->redirectToRoute('web_user_get_list');
        }

        $this->commandBus->dispatch(
            new DeleteUserCommand(Uuid::fromString($uuid))
        );

        $this->setFlashMessage($request, FlashMessageEnum::DONE, $this->translator->trans('user.delete_success'));
        return $this->redirectToRoute('web_user_get_list');
    }
}
