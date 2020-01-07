<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\CommentRepository;
use App\services\ShowArticle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
        $showArticle = new ShowArticle($em);
        $articles = $showArticle->processed();

        return $this->render('article/show.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/news/{id}", name="full_article_show")
     */
    public function articleShow(EntityManagerInterface $em, $id)
    {

        $repository = $em->getRepository(Article::class);
        /** @var Article $article */
        $article = $repository->findById($id);
        if (!$article) {
            throw $this->createNotFoundException('No this articles at db');
        }

        return $this->render('article/one.html.twig', [
            'title' => $article['title'],
            'content' => $article['content'],
            'image'=> $article['image'],
        ]);
    }


}

