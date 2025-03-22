<?php

declare(strict_types=1);

namespace ArmorCMS\TextBlock\CommandHandler;

use ArmorCMS\Shared\CommandHandler\CommandHandlerInterface;
use ArmorCMS\TextBlock\Command\DeleteTextBlock;
use ArmorCMS\TextBlock\Repository\TextBlockRepository;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DeleteTextBlockCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private TextBlockRepository $textBlockRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(DeleteTextBlock $command): void
    {
        $textBlock = $this->textBlockRepository->findByUuid($command->uuid);

        if (null === $textBlock) {
            return;
        }

        $this->entityManager->remove($textBlock);
    }
}
