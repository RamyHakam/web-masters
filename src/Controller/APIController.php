<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class APIController extends AbstractController
{
    /**
     * @Route("/api/account",name="api")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function api(): Response
    {
        return new JsonResponse(['test'=>'account']);
    }

    /**
     * @Route("/api/login",name="api_login")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function apiLogin(#[CurrentUser] $user): Response
    {
        $token = spl_object_hash($user);
        return new JsonResponse(['token'=>$token]);
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