<?php
declare(strict_types=1);

namespace ArmorCMS\Shared\EventSubscriber;

use Gedmo\Blameable\BlameableListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final readonly class RequestSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private TokenStorageInterface         $tokenStorage,
        private AuthorizationCheckerInterface $authorizationChecker,
        private BlameableListener             $blameableListener
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (
            null === $this->tokenStorage->getToken()?->getUser()
            || false === $this->authorizationChecker->isGranted('ROLE_USER')
            || false ===$event->isMainRequest()
        ) {
            return;
        }

        $this->blameableListener->setUserValue($this->tokenStorage->getToken()->getUser());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }
}