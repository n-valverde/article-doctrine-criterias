<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Order;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public const DEFAULT_BEST_SELLERS_LIMIT = 3;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public static function createBestSellersCriteria(int $limit = self::DEFAULT_BEST_SELLERS_LIMIT): Criteria
    {
        return Criteria::create()
            ->andWhere(Criteria::expr()->neq('rating', null))
            ->orderBy(['rating' => Order::Descending])
            ->setMaxResults($limit)
        ;

    }

    public function findBestSellers(string $author, int $limit = self::DEFAULT_BEST_SELLERS_LIMIT): array
    {
        return $this->createQueryBuilder('b')
            ->select('b')
            ->addCriteria(self::createBestSellersCriteria($limit))
            ->join('b.authors', 'a', Expr\Join::WITH, 'a.name = :author')
            ->setParameter('author', $author)
            ->getQuery()
            ->getResult()
        ;
    }
}
