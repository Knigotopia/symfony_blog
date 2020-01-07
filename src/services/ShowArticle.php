<?php


namespace App\services;


use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowArticle
{
    /**
     * EntityManagerInterface $em
     */
    private $em;

    /**
     * ShowArticle constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)

    {
        $this->em = $em;
    }

    public function processed() {
        $repository = $this->em->getRepository(Article::class);
        /** @var Article[] $articles */
        $articles = $repository->getAllRecords();
        if (!$articles) {
            throw new NotFoundHttpException('No articles at db');
        }

        return $articles;
    }

}