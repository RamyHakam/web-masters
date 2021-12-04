<?php


namespace App\Controller;


use App\Entity\MyData;
use App\Entity\User;
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
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{


    /**
     * @var MyOwnServiceLocator
     */
    private $serviceLocator;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(MyOwnServiceLocator $serviceLocator,EntityManagerInterface  $entityManager)
    {

        $this->serviceLocator = $serviceLocator;
        $this->entityManager = $entityManager;
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
     * @Route("/post/{email}/{name}",name="user_post")
     * @ParamConverter("user",options={"mapping":{"name":"name"}})
     * @ParamConverter("data",options={"mapping":{"email":"email"}})
     * @return Response
     */
    public function post(User $user,MyData $data)
    {
      return  $this->render('post.html.twig',['user' => $user,'data' =>$data]);
    }

    /**
     * @Route("/list",name="list_users")
     * @return Response
     */
    public function listUser()
    {
        $repository = $this->entityManager->getRepository(User::class);
        $users = $repository->findByPastUsingMyDql('Frontend');
        return  $this->render('List.html.twig',['users' => $users]);
    }

    /**
     * @Route("/search/{term}",name="search_users")
     * @return Response
     */
    public function searchUser($term)
    {
        $repository = $this->entityManager->getRepository(User::class);
        $users = $repository->findByTerm($term);
        return  $this->render('List.html.twig',['users' => $users]);
    }

    /**
     * @Route("/getUser/{name}",name="new_user")
     * @return Response
     */
    public function getUserByName(string  $name)
    {
        $repository = $this->entityManager->getRepository(User::class);

      $user =  $repository->findOneBy(['name' => $name]);

        dd($user->getName());


        return  new Response('welcome to doctrine!');
    }
}