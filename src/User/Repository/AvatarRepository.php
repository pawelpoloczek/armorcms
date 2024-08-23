<?php
declare(strict_types=1);

namespace ArmorCMS\User\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use ArmorCMS\Shared\Repository\EntityRepository;
use ArmorCMS\User\DTO\GetAvatar;
use ArmorCMS\User\Entity\Avatar;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Avatar>
 *
 * @method Avatar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avatar|null findByUuid(Uuid $uuid)
 * @method Avatar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avatar[]    findAll()
 * @method Avatar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class AvatarRepository extends EntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avatar::class);
    }

    /**
     * @param Avatar $entity
     * @return GetAvatar
     */
    protected function getMappedEntity(mixed $entity): mixed
    {
        return new GetAvatar(
            $entity->getUuid(),
            $entity->getFileName(),
            $entity->getOriginalName()
        );
    }
}
