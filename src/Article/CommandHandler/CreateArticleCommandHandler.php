<?php
declare(strict_types=1);

namespace ArmorCMS\Article\CommandHandler;

use ArmorCMS\Article\Command\CreateArticle;
use ArmorCMS\Article\Entity\Article;
use ArmorCMS\Article\Entity\Seo;
use ArmorCMS\Shared\CommandHandler\CommandHandlerInterface;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

final readonly class CreateArticleCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UuidFactory $uuidFactory,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(CreateArticle $command): void
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

        $article = new Article(
            $command->uuid,
            $command->title,
            $command->slug,
            $command->isActive,
            $publicationDate,
            $command->author,
            $command->content,
            $seo
        );

        $this->entityManager->persist($article);
        $this->entityManager->flush();
    }
}