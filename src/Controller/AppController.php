<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/{name}")
     * @return Response
     */
    public function index(string  $name)
    {
        $users = ['ramy' , 'tamer' , 'mona','ahmed','ayat'];
        return $this->render('base.html.twig',['users' => $users]);
    }
}