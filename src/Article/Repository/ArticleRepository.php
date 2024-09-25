<?php
declare(strict_types=1);

namespace ArmorCMS\Article\Repository;

use ArmorCMS\Article\DTO\GetArticle;
use ArmorCMS\Article\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use ArmorCMS\Shared\Repository\EntityRepository;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findByUuid(Uuid $uuid)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ArticleRepository extends EntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @param Article $entity
     * @return GetArticle
     */
    protected function getMappedEntity(mixed $entity): mixed
    {
        return new GetArticle(
            $entity->getUuid(),
            $entity->getTitle(),
            $entity->isActive(),
            $entity->getSlug()
        );
    }
}
