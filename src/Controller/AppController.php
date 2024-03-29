<?php


namespace App\Controller;


use App\Entity\Customer\Offer;
use App\Entity\Main\Address;
use App\Entity\Main\Article;
use App\Entity\Main\Page;
use App\Entity\Main\Post;
use App\Entity\Main\SymfonyGroup;
use App\Entity\Main\User;
use App\Form\AccountFormType;
use App\Form\UserRegisterType;
use App\Service\CustomService;
use App\Service\EncryptPasswordService;
use App\Service\FirstActionService;
use App\Service\MyOwnServiceLocator;
use App\Service\RandomNumberService;
use App\Service\ThirdActionService;
use App\Service\UploadService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Hakam\MultiTenancyBundle\Doctrine\ORM\TenantEntityManager;
use Hakam\MultiTenancyBundle\Event\SwitchDbEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    private EventDispatcherInterface $dispatcher;
    private LoggerInterface $logger;

    public function __construct(MyOwnServiceLocator $serviceLocator,EntityManagerInterface  $entityManager,EventDispatcherInterface  $dispatcher,
LoggerInterface  $logger)
    {

        $this->serviceLocator = $serviceLocator;
        $this->entityManager = $entityManager;
        $this->dispatcher = $dispatcher;
        $this->logger = $logger;
    }


    /**
     * @Route("/login",name="login_page")
     * @return Response
     */
    public function login( Request  $request,AuthenticationUtils  $authenticationUtils)
    {
        $form = $this->createForm(AccountFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $user = $data['email'];
        }
        return $this->render('login.html.twig',['form' => $form->createView(),'error' => $authenticationUtils->getLastAuthenticationError()]);
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
    public function signUp( Request  $request, EncryptPasswordService  $encryptPassword, UploadService  $uploadService)
    {
        $form = $this->createForm(UserRegisterType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            try{
                /**@var User $userData */

                $userData = $form->getData();
                $plainPassword = $form['plainPassword']->getData();
                /** @var UploadedFile $userPhoto */
                $userPhoto = $form['userPhoto']->getData();
                $avatarName = $uploadService->upload($userPhoto);
               $userData->setAvatar($avatarName);
                $userData->setPassword($encryptPassword->encryptPassword($plainPassword));
                $userData->setActive(true);
                $this->entityManager->persist($userData);
                $this->entityManager->flush();
                $this->addFlash('success','User created successfully');

            }catch (Exception $e){
                $this->addFlash('error','Errors while creating user');

            }
        }

       return $this->render('signup.html.twig',['form' => $form->createView()]);
    }



    /**
     * @Route("/edit/{id}",name="edit_page")
     * @return Response
     */
    public function update( User $user, Request  $request )
    {
        $form = $this->createForm(UserRegisterType::class,$user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            try{
                /**@var User $userData */
                $userData = $form->getData();
                $userData->setActive(true);
                $this->entityManager->persist($userData);
                $this->entityManager->flush();
                $this->addFlash('success','User updated successfully');

            }catch (Exception $e){
                $this->addFlash('error','Errors while updating user');

            }
        }

        return $this->render('edit.html.twig',['form' => $form->createView()]);
    }


    /**
     * @Route("/post/{id}",name="user_post")

     * @return Response
     */
    public function post(User $user)
    {
      return  $this->render('post.html.twig',['user' => $user]);
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
     * @Route("/update/{id}",name="search_users")
     * @return Response
     */
    public function updateUser(User  $user)
    {
        $user->setName('Updated Name To Test');
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return  new Response('User Updated');
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

    /**
     * @Route("/addUserAndPost/{name}",name="new_user")
     * @return Response
     */
    public function addUserAndPost(string  $name,EntityManagerInterface  $entityManager)
    {
        $user = new User();
        $user->setEmail('tesdddlkddt@yahoo.com')
            ->setName($name)
            ->setActive(true)
            ->setPhone('109304')
            ->setPassword('123456')
            ->setDateOfBirth(new \DateTime())
            ->setPast('LEAD')
            ->setTitle('CEO');

        $post = new Post();
        $post->setLikes(100)
            ->setPhoto('https://google.comdkd/png')
            ->setCreatedAt(new \DateTime());
        $post->setUser($user);
        
        $post2 = new Post();
        $post2->setLikes(103030)
            ->setPhoto('https://fb.com/png')
            ->setCreatedAt(new \DateTime());

        $post2->setUser($user);

        $entityManager->persist($user);
        $entityManager->persist($post);
        $entityManager->persist($post2);

        $entityManager->flush();

        return  new Response('welcome to doctrine!');
    }

    /**
     * @Route("/addUserAndAddress/{name}",name="new_user_address")
     * @return Response
     */
    public function addUserAndAddress(string  $name,EntityManagerInterface  $entityManager)
    {
        $user = new User();
        $user->setEmail('tes2022@yahoo.com')
            ->setName($name)
            ->setActive(true)
            ->setPhone('109304')
            ->setCreatedAt(new \DateTime())
            ->setDateOfBirth(new \DateTime())
            ->setPast('LEAD')
            ->setTitle('CEO');

        $address = new Address();
        $address->setUser($user)
            ->setCity('Giza')
            ->setStreet('40595')
            ->setNumber(1);


        $entityManager->persist($user);
        $entityManager->persist($address);

        $entityManager->flush();

        return  new Response('welcome to doctrine one to one relationship!');
    }

    /**
     * @Route("/addUserAndinvitee/{name}",name="new_user_and_invitee")
     * @return Response
     */
    public function addUserAndInvitee(string  $name,EntityManagerInterface  $entityManager)
    {
        $user = new User();
        $user->setEmail('tes2022@yahoo.com')
            ->setName($name)
            ->setActive(true)
            ->setPhone('109304')
            ->setCreatedAt(new \DateTime())
            ->setDateOfBirth(new \DateTime())
            ->setPast('LEAD')
            ->setTitle('CEO');
        $user2 = new User();
        $user2->setEmail('newaccount@yahoo.com')
            ->setName('newaccount')
            ->setActive(true)
            ->setPhone('109303003304')
            ->setCreatedAt(new \DateTime())
            ->setDateOfBirth(new \DateTime())
            ->setPast('LEAD')
            ->setTitle('CEO')
            ->setInvitedBy($user);

        $entityManager->persist($user);
        $entityManager->persist($user2);
        $entityManager->flush();

        return  new Response('welcome to doctrine self joining relationship!');
    }

    /**
     * @Route("/addUserAndGroup/{name}",name="new_user_and_group")
     * @return Response
     */
    public function addUserAndGroup(string  $name,EntityManagerInterface  $entityManager)
    {
        $group = new SymfonyGroup();
        $this->entityManager->persist($group);

        $user = new User();
        $user->setEmail('test2030@yahoo.com')
            ->setName($name)
            ->setActive(true)
            ->setPhone('10900304')
            ->setCreatedAt(new \DateTime())
            ->setDateOfBirth(new \DateTime())
            ->setPast('LEAD')
            ->setTitle('CEO');
        $user2 = new User();
        $user2->setEmail('newaccount7887@yahoo.com')
            ->setName('newaccount')
            ->setActive(true)
            ->setPhone('109jkk303003304')
            ->setCreatedAt(new \DateTime())
            ->setDateOfBirth(new \DateTime())
            ->setPast('LEAD')
            ->setTitle('CEO')
            ->setInvitedBy($user);

        $user->joinGroup($group);
        $user2->joinGroup($group);

        $entityManager->persist($user);
        $entityManager->persist($user2);

        $entityManager->flush();

        return  new Response('welcome to doctrine many to many relationship!');
    }


    /**
     * @Route("/addDataToCustomerDb/{id}",name="add_data_to_customer_db")
     * @return Response
     */
    public function addDataToCustomerDbObject(User $user, TenantEntityManager  $tenantEntityManager)
    {

        $dbSwitchEvent = new SwitchDbEvent($user->getDbid());
        $this->dispatcher->dispatch($dbSwitchEvent);
        
        $offer = new Offer();
        $offer->setCode('12340#');
        $offer->setPrice('3000');
        $offer->setItems('MacBook');
        $tenantEntityManager->persist( $offer);
        $tenantEntityManager->flush($offer);

        $offer2 = new Offer();
        $offer2->setCode('Customer2DB#');
        $offer2->setPrice('400');
        $offer2->setItems('DELL');

        $dbSwitchEvent = new SwitchDbEvent(2);
        $this->dispatcher->dispatch($dbSwitchEvent);
        $tenantEntityManager->persist($offer2);
        $tenantEntityManager->flush($offer2);
        return  new Response('welcome to doctrine one to one relationship!');
    }


    /**
     * @Route("/addpage/{id}",name="add_page")
     * @return Response
     */
    public function addPage(User $user)
    {
//        $page = new Page();
//        $page->setName('page name')
//            ->setDescription('page description')
//            ->setUser($user)
//            ->setCreatedAt(new \DateTime());
//        $this->entityManager->persist($page);
//        $this->entityManager->flush();

        $page = new Page();
        $page->setName('page name 2 from user side ')
            ->setDescription('page description')
            ->setStatus(Page::STATUS_DRAFT);

        $user->addPage($page);
        $this->entityManager->persist($page);
        $this->entityManager->flush();

               return  new Response('welcome to doctrine owning and inverse side!');
    }

    /**
     * @Route("/logout",name="/logout_page")
     * @return Response
     */
    public function logout()
    {
        $test = 'test';
    }

    /**
     * @Route("/home",name="home_page")
     ** @IsGranted("ROLE_USER")
     * @return Response
     */
    public function home( FirstActionService $service): Response
    {
        $service->logTheCurrentUser();
        $this->logger->info('User has been logged in {user}', ['user' =>$this->getUser()->getUserIdentifier()]);
        return $this->render('home.html.twig');
    }
}