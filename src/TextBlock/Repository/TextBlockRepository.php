<?php

declare(strict_types=1);

namespace ArmorCMS\TextBlock\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use ArmorCMS\Shared\Repository\EntityRepository;
use ArmorCMS\TextBlock\DTO\TextBlock as TextBlockDTO;
use ArmorCMS\TextBlock\Entity\TextBlock;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<TextBlock>
 *
 * @method TextBlock|null find($id, $lockMode = null, $lockVersion = null)
 * @method TextBlock|null findByUuid(Uuid $uuid)
 * @method TextBlock|null findOneBy(array $criteria, array $orderBy = null)
 * @method TextBlock[]    findAll()
 * @method TextBlock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class TextBlockRepository extends EntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TextBlock::class);
    }

    /**
     * @param TextBlock $entity
     * @return TextBlockDTO
     */
    protected function getMappedEntity(mixed $entity): mixed
    {
        return new TextBlockDTO(
            $entity->isActive(),
            $entity->getContent()
        );
    }
}
