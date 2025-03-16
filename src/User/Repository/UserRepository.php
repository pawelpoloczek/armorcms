<?php

declare(strict_types=1);

namespace ArmorCMS\User\Repository;

use ArmorCMS\Shared\Exception\EntityNotFound;
use ArmorCMS\Shared\Repository\EntityRepository;
use ArmorCMS\User\DTO\GetUser;
use ArmorCMS\User\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findByUuid(Uuid $uuid)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class UserRepository extends EntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getForPreview(Uuid $uuid): object
    {
        $entity = $this->findByUuid($uuid);
        if (null === $entity) {
            throw new EntityNotFound($uuid, User::class);
        }

        // @todo - return DTO
        return $entity;
    }

    /**
     * @param User $entity
     * @return GetUser
     */
    protected function getMappedEntity(mixed $entity): mixed
    {
        return new GetUser(
            $entity->getUuid(),
            $entity->getUsername(),
            $entity->getEmail(),
            $entity->isAdmin()
        );
    }
}
