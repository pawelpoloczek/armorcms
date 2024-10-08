<?php
declare(strict_types=1);

namespace ArmorCMS\Page\CommandHandler;

use ArmorCMS\Page\Command\CreatePage;
use ArmorCMS\Page\Entity\Page;
use ArmorCMS\Page\Entity\Seo;
use ArmorCMS\Shared\CommandHandler\CommandHandlerInterface;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

final readonly class CreatePageCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UuidFactory $uuidFactory,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(CreatePage $command): void
    {
        $seo = new Seo(
            $this->uuidFactory->create(),
            $command->seo->title,
            $command->seo->description,
            $command->seo->robots,
            $command->seo->ogTitle,
            $command->seo->ogDescription,
            $command->seo->ogSection,
            $command->seo->ogTags
        );

        $this->entityManager->persist($seo);

        $publicationDate = null;
        if ($command->isActive) {
            $publicationDate = new DateTimeImmutable();
        }

        $page = new Page(
            $command->uuid,
            $command->title,
            $command->slug,
            $command->isActive,
            $publicationDate,
            $command->author,
            $command->content,
            $seo
        );

        $this->entityManager->persist($page);
        $this->entityManager->flush();
    }
}