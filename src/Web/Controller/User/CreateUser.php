<?php
declare(strict_types=1);

namespace ArmorCMS\Web\Controller\User;

use ArmorCMS\User\Command\CreateUser as CreateUserCommand;
use ArmorCMS\Web\Enum\FlashMessageEnum;
use ArmorCMS\Web\Form\User\CreateUserType;
use ArmorCMS\Web\Trait\FlashMessageTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Factory\UuidFactory;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(name: 'web_')]
final class CreateUser extends AbstractController
{
    use FlashMessageTrait;

    public function __construct(
        private readonly UuidFactory $uuidFactory,
        private readonly MessageBusInterface $commandBus,
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route(
        '/settings/users/create',
        name: 'user_create',
        methods: [Request::METHOD_GET, Request::METHOD_POST]
    )]
    public function __invoke(
        Request $request
    ): Response {
        $form = $this->createForm(CreateUserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userUuid = $this->uuidFactory->create();

            $this->commandBus->dispatch(
                new CreateUserCommand(
                    $userUuid,
                    $form->getData()['username'],
                    $form->getData()['email'],
                    $form->getData()['password'],
                    $form->getData()['isAdmin'],
                    $form->getData()['avatar']
                )
            );

            $this->setFlashMessage(
                $request,
                FlashMessageEnum::DONE,
                $this->translator->trans('user.add_success')
            );

            return $this->redirectToRoute('web_user_get_list');
        }

        return $this->render('User/user_create.html.twig', [
            'formUser' => $form->createView(),
        ]);
    }
}
