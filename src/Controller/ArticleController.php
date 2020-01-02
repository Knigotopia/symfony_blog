<?php

namespace App\Controller;

use App\Entity\Article;
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

    public function show(EntityManagerInterface $em) {

        $repository = $em->getRepository(Article::class);
        /** @var Article $article */
        $article = $repository->findAll();
        if (!$article) {
            throw $this->createNotFoundException(sprintf('No article for title "%s"', $title));
        }

        return $this->render('article/show.html.twig', [
            'title' => 'Title',
            'content' => 'content',
        ]);
    }

}

