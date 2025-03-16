<?php

declare(strict_types=1);

namespace ArmorCMS\Shared\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Uid\Uuid;

use function count;

abstract class EntityRepository extends ServiceEntityRepository implements IterableRepositoryInterface
{
    private const BATCH_COUNT = 100;

    abstract public function getForPreview(Uuid $uuid): object;
    abstract protected function getMappedEntity(mixed $entity): mixed;

    public function findAllIterable(): iterable
    {
        return $this->findByCriteriaIterable(['deletedAt' => null]);
    }

    public function findByCriteriaIterable(array $criteria): iterable
    {
        $offset = 0;

        do {
            $entities = $this->findBy($criteria, null, self::BATCH_COUNT, $offset);

            foreach ($entities as $entity) {
                yield $this->getMappedEntity($entity);
            }

            $offset += self::BATCH_COUNT;
            $this->getEntityManager()->clear($this->_entityName);
        } while (count($entities) > 0);
    }

    public function findByUuid(Uuid $uuid): ?object
    {
        return $this->findOneBy(
            [
                'uuid' => (string)$uuid,
                'deletedAt' => null,
            ]
        );
    }
}
