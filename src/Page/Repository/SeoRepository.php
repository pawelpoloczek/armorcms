<?php

declare(strict_types=1);

namespace ArmorCMS\Page\Repository;

use ArmorCMS\Page\Entity\Seo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @method Seo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seo|null findByUuid(Uuid $uuid)
 * @method Seo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seo[]    findAll()
 * @method Seo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class SeoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seo::class);
    }
}
