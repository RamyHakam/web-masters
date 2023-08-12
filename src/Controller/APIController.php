<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('ROLE_USER') and user.getFirstName() === 'Ramy1' ")
 */
class APIController extends AbstractController
{
    /**
     * @Route("/api/account",name="api")
     * @return Response
     */
    public function api(): Response
    {
        return new JsonResponse(['test'=>'account']);
    }

    /**
     * @Route("/api/posts",name="api-posts")
     * @return Response
     */
    public function getPosts(): Response
    {
        return new JsonResponse(['test'=>'posts']);
    }

    /**
     * @Route("/api/product",name="api-products")
     * @return Response
     */
    public function getProducts(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if($this->isGranted('ROLE_ADMIN'))
        {
            throw  new AccessDeniedException('You are not allowed to access this page');
        }
        return new JsonResponse(['test'=>'products']);
    }

}