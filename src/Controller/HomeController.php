<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\AddPostType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class HomeController extends AbstractController
{
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(PostRepository $repo, UserRepository $repo2): Response
    {
        $posts = $repo->findBy([], ['createdAT' => 'DESC']);;
        


        return $this->render('home/index.html.twig', ['posts' => $posts]);
    }

    #[Route('/post', name: 'app_createpost')]
    public function post(EntityManagerInterface $entityManager, Request $request): Response
    {
        $addpost = new Post();
        $user = $this->getUser();
        $addpost->setUser($user);
        $form = $this->createForm(AddPostType::class, $addpost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager->persist($addpost, $user);
            $entityManager->flush();

            return new RedirectResponse($this->urlGenerator->generate('app_home'));
        }

        // dd($addpost);

        return $this->render('post/index.html.twig', [
            'addpost' => $form->createView(),
        ]);
    }

    #[Route('/post/{id}', name: 'app_id', methods: ['GET'])]
    public function show(PostRepository $repo, $id): Response
    {
        $post = $repo->find($id);

        return $this->render('post/show.html.twig', ['post' => $post]);
    }
}
