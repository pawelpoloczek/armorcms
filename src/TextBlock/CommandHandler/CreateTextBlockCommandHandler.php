<?php

declare(strict_types=1);

namespace ArmorCMS\TextBlock\CommandHandler;

use ArmorCMS\Shared\CommandHandler\CommandHandlerInterface;
use ArmorCMS\TextBlock\Command\CreateTextBlock;
use ArmorCMS\TextBlock\Entity\TextBlock;
use ArmorCMS\TextBlock\Repository\TextBlockRepository;

final readonly class CreateTextBlockCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private TextBlockRepository $textBlockRepository
    ) {}

    public function __invoke(CreateTextBlock $command): void
    {
        $this->textBlockRepository->save(
            new TextBlock(
                $command->uuid,
                $command->title,
                $command->isActive,
                $command->content,
                $command->description,
            )
        );
    }
}
