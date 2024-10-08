<?php
declare(strict_types=1);

namespace ArmorCMS\Page\Repository;

use ArmorCMS\Page\DTO\Page as PageDTO;
use ArmorCMS\Page\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use ArmorCMS\Shared\Repository\EntityRepository;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Page>
 *
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findByUuid(Uuid $uuid)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class PageRepository extends EntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    /**
     * @param Page $entity
     * @return PageDTO
     */
    protected function getMappedEntity(mixed $entity): mixed
    {
        return new PageDTO(
            $entity->getUuid(),
            $entity->getTitle(),
            $entity->isActive(),
            $entity->getSlug()
        );
    }
}
