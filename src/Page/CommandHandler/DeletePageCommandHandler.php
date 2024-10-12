<?php

declare(strict_types=1);

namespace ArmorCMS\Page\CommandHandler;

use ArmorCMS\Page\Command\DeletePage;
use ArmorCMS\Page\Repository\PageRepository;
use ArmorCMS\Shared\CommandHandler\CommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DeletePageCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private PageRepository $pageRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(DeletePage $command): void
    {
        $page = $this->pageRepository->findByUuid($command->uuid);

        if (null === $page) {
            return;
        }

        $page->delete();

        $this->entityManager->flush();
    }
}
