<?php

declare(strict_types=1);

namespace ArmorCMS\Page\CommandHandler;

use ArmorCMS\Page\Command\CreatePage;
use ArmorCMS\Page\Entity\Page;
use ArmorCMS\Page\Entity\Route;
use ArmorCMS\Page\Entity\Seo;
use ArmorCMS\Page\Repository\PageRepository;
use ArmorCMS\Shared\CommandHandler\CommandHandlerInterface;
use DateTimeImmutable;
use Symfony\Component\Uid\Factory\UuidFactory;

final readonly class CreatePageCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UuidFactory $uuidFactory,
        private PageRepository $pageRepository
    ) {
    }

    public function __invoke(CreatePage $command): void
    {
        $publicationDate = null;
        if ($command->isActive) {
            $publicationDate = new DateTimeImmutable();
        }

        $page = new Page(
            $command->uuid,
            $command->title,
            $command->isActive,
            $publicationDate,
            $command->author,
            $command->content,
            new Route(
                $this->uuidFactory->create(),
                $command->slug
            ),
            new Seo(
                $this->uuidFactory->create(),
                $command->seo->title ?: $command->title,
                $command->seo->description ?: null,
                $command->seo->robots ?: [],
                $command->seo->ogTitle ?: $command->title,
                $command->seo->ogDescription ?: null,
                $command->seo->ogSection ?: null,
                $command->seo->ogTags ?: []
            )
        );

        $this->pageRepository->save($page);
    }
}