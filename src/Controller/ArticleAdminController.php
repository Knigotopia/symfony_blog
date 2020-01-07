<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use App\services\ShowArticle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/create", name="article_admin")
     */
    public function new(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(ArticleFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Article $article */
            $article = $form->getData();
            $article->setCreatedAt(new \DateTime('now'));

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('admin_article_list');
        }

        return $this->render('article_admin/new.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/article/edit/{id}", name="article_edit")
     */
    public function edit(Article $article, EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(ArticleFormType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Article $article */
            $article = $form->getData();
            $article->setCreatedAt(new \DateTime('now'));

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('admin_article_list');
        }

        return $this->render('article_admin/edit.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/article/delete/{id}", name="article_delete")
     */
    public function delete(Article $article, EntityManagerInterface $em, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

       $em->remove($article);
       $em->flush();

       return $this->redirectToRoute('admin_article_list');
    }

    /**
     * @Route("/admin/article", name="admin_article_list")
     */
    public function list(EntityManagerInterface $em, ArticleRepository $articleRepo)
    {
        $showArticle = new ShowArticle($em);
        $articles = $showArticle->processed();

        return $this->render('article_admin/list.html.twig', [
            'articles' => $articles,
        ]);
    }

}
