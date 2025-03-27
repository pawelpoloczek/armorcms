<?php

declare(strict_types=1);

namespace ArmorCMS\Page\Repository;

use ArmorCMS\Page\DTO\Page as PageDTO;
use ArmorCMS\Page\DTO\PreviewPage;
use ArmorCMS\Page\DTO\PreviewSeo;
use ArmorCMS\Page\Entity\Page;
use ArmorCMS\Shared\Exception\EntityNotFound;
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

    public function getForPreview(Uuid $uuid): object
    {
        $entity = $this->findByUuid($uuid);
        if (null === $entity) {
            throw new EntityNotFound($uuid, Page::class);
        }

        $seo = new PreviewSeo(
            $entity->getSeo()?->getTitle(),
            $entity->getSeo()?->getDescription(),
            $entity->getSeo()?->getRobots(),
            $entity->getSeo()?->getOgTitle(),
            $entity->getSeo()?->getOgDescription(),
            $entity->getSeo()?->getOgSection(),
            $entity->getSeo()?->getOgTags(),
        );

        return new PreviewPage(
            $entity->getUuid(),
            $entity->getCreatedAt(),
            $entity->getUpdatedAt(),
            $entity->getCreatedBy(),
            $entity->getUpdatedBy(),
            $entity->getTitle(),
            $entity->isActive(),
            $entity->getRoute()->getSlug(),
            $entity->getPublicationDate(),
            $entity->getAuthor(),
            $seo
        );
    }

    public function save(Page $page): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($page->getSeo());
        $entityManager->persist($page->getRoute());
        $entityManager->persist($page);
        $entityManager->flush();
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
            $entity->getRoute()->getSlug()
        );
    }
}
