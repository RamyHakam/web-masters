<?php


namespace App\Controller;


use App\Service\CommonInterface;
use App\Service\CustomService;
use App\Service\FirstActionService;
use App\Service\FirstClassService;
use App\Service\FirstService;
use App\Service\HeavyService;
use App\Service\MyOwnServiceLocator;
use App\Service\RandomNumberService;
use App\Service\SecondActionService;
use App\Service\ThirdActionService;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{


    /**
     * @var MyOwnServiceLocator
     */
    private $serviceLocator;

    public function __construct(MyOwnServiceLocator $serviceLocator)
    {

        $this->serviceLocator = $serviceLocator;
    }


    /**
     * @Route("/signin_user",name="signin_page")
     * @return Response
     */
    public function index(RandomNumberService  $number,CustomService  $custom)
    {

        dd(get_class($this->serviceLocator->doAction(ThirdActionService::class)));
        $number = $numberService->getRandomNumber(1000, 100000);
        return $this->render('home.html.twig',['user' => 'test']);
    }

    /**
     * @Route("/signup",name="signup_page")
     * @return Response
     */
    public function signUp()
    {
       return $this->render('signup.html.twig');
    }

    /**
     * @Route("/post/{name}",name="user_post")
     * @return Response
     */
    public function post(string  $name)
    {
      return  $this->render('post.html.twig',['name' => $name]);
    }
}