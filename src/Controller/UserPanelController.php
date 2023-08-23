<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserPanelController extends AbstractController
{
    /**
     * @Route("/user-panel", name="user_panel")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }
 /**
     * @Route("/user_password_change", name="user_password_change")
     */
    public function changePassword(): Response
    {
        return $this->render('user/password_change.html.twig');
    }

}