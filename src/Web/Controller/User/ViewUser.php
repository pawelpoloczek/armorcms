<?php
declare(strict_types=1);

namespace ArmorCMS\Web\Controller\User;

use ArmorCMS\User\Repository\AvatarRepository;
use ArmorCMS\User\Repository\UserRepository;
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
final class ViewUser extends AbstractController
{
    use FlashMessageTrait;

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly TranslatorInterface $translator,
        private readonly AvatarRepository $avatarRepository,
        private readonly string $userAvatarWebPath
    ) {
    }

    #[Route(
        '/settings/users/view/{uuid}',
        name: 'user_view',
        requirements: ['uuid' => Requirement::UUID_V7],
        methods: [Request::METHOD_GET]
    )]
    public function __invoke(
        string $uuid,
        Request $request
    ): Response {
        $user = $this->userRepository->findByUuid(Uuid::fromString($uuid));
        if (null === $user) {
            $this->setFlashMessage(
                $request,
                FlashMessageEnum::ERROR,
                $this->translator->trans('user.not_found')
            );

            return $this->redirectToRoute('web_user_get_list');
        }

        $avatar = $this->avatarRepository->findOneBy(['user' => $user]);
        if (null !== $avatar) {
            $avatar = sprintf(
                '%s/%s/%s',
                $this->userAvatarWebPath,
                'large',
                $avatar->getOriginalName()
            );
        }

        return $this->render('User/user_view.html.twig', [
            'user' => $user,
            'avatar' => $avatar,
        ]);
    }
}
