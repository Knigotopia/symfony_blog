<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\DocBlock\Tags\Author;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getAllRecords($limit = null): array
    {
        $query = $this->createQueryBuilder('a')
                      ->select(
                          'a.id',
                          'a.title',
                          'a.content',
                          'a.description',
                          'a.image',
                          'a.author',
                          'a.createdAt'
                      )
                      ->orderBy('a.id', 'ASC');
        if ($limit) {
            $query->setMaxResults($limit);
        }

        $articles = $query->getQuery()->getResult();

        return $articles ?: [];
    }

    /**
     * @param int $id
     * @return array
     */
    public function findById($id): array
    {
        $query = $this->createQueryBuilder('a')
                      ->select(
                          'a.id',
                          'a.title',
                          'a.content',
                          'a.description',
                          'a.image',
                          'a.author',
                          'a.createdAt'
                      )
                    ->andWhere('a.id = :id')
                    ->setParameter('id', $id);

        $article = $query->getQuery()->getOneOrNullResult();

        return $article ?: [];
    }

}
