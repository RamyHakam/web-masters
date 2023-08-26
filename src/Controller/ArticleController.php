<?php

namespace App\Controller;

use App\Entity\Main\Article;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/articles",name="app_articles")
     ** @IsGranted("ROLE_USER")
     * @return Response
     */
    public function articles( ): Response
    {
         if($this->isGranted('ROLE_ADMIN')){
             return $this->render('article.html.twig',['account' => $this->getUser(),'articles' => $this->entityManager->getRepository(Article::class)->findAll()]);
         }
        return $this->render('article.html.twig',['account' => $this->getUser(),'articles' => $this->getUser()->getArticles()]);
    }

    /**
     * @Route("/article/{id}/edit", name="article_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $this->denyAccessUnlessGranted('EDIT', $article);
        if ($request->isMethod('POST')) {
            $article->setPhoto($request->request->get('photo'));
            $article->setContent($request->request->get('content'));
            $article->setLikes($request->request->getInt('likes'));

            $this->entityManager->persist($article);
            $this->entityManager->flush();

            $this->addFlash('success', 'Article updated successfully!');

            return $this->redirectToRoute('app_articles');
        }

        return $this->render('article_edit.html.twig', ['article' => $article]);
    }
    /**
     * @Route("/article/{id}/delete", name="article_delete", methods={"GET", "POST"})
     */
    public function delete(Request $request, Article $article): Response
    {
        $this->denyAccessUnlessGranted('DELETE', $article);
        if ($request->isMethod('POST')) {

            $this->entityManager->remove($article);
            $this->entityManager->flush();

            $this->addFlash('success', 'Article deleted successfully!');

            return $this->redirectToRoute('app_articles');
        }
        return $this->render('article_delete.html.twig', ['article' => $article]);
    }
}