<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    /**
     * @Route("/news/", name="article_show")
     */
    public function show(EntityManagerInterface $em)
    {

        $repository = $em->getRepository(Article::class);
        /** @var Article[] $articles */
        $articles = $repository->getAllRecords();
        if (!$articles) {
            throw $this->createNotFoundException('No articles at db');
        }
//        foreach ($articles as $article) {
//            $title   = $article->getTitle();
//            $content = $article->getContent();
//        }

//        if (!$article) {
//            throw $this->createNotFoundException(sprintf('No article for title "%s"', $title));
//        }

        return $this->render('article/show.html.twig', [
            'articles' => $articles,
//            'title' => 'Title',
//            'content' => 'content',
        ]);
    }

    /**
     * @Route("/news/{id}", name="full_article_show")
     */
    public function articleShow(EntityManagerInterface $em, $id)
    {

        $repository = $em->getRepository(Article::class);
        /** @var Article $article */
//        $articles = $repository->find(['id' => $id]);
        $article = $repository->findById($id);
        if (!$article) {
            throw $this->createNotFoundException('No this articles at db');
        }

        return $this->render('article/one.html.twig', [
            'title' => $article->getTitle(),
            'content' => $article->getContent()
        ]);
    }


}

