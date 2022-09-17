<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="app_blog")
     */
    public function index(ArticleRepository $articleRepository ,
     PaginatorInterface $paginator , Request $request)

     
    {

       $articles = $paginator->paginate( $articleRepository->findAll(),
       $request->query->getInt('page',1),
       
       3
    );

        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
        ]);
    }
      /**
     * @Route("/article/new" , name = "new_article")
     */
    public function new(Request $request){
        $article = new Article();
        $form = $this->createForm(ArticleType::class , $article);
        $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
        $article->setImage("https://picsum.photos/500/300?grayscale");
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();


       }




        return $this->render('blog/new.html.twig', ['form'=>$form->createView()]);


    }
    /**
     * @Route("article/{id}/edit" , name = "article_edit")
     */
    public function edit(Request $request , Article $article) 
    {
        $form = $this->createForm(ArticleType::class , $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
         return  $this->redirectToRoute("article_show",['id'=>$article->getId()])  ; 

    }
    return $this->render("blog/edit.html.twig",['form'=>$form->createView()]);
    }

    /**
     * @Route("/article/{id}" , name="article_show")
     */
    public function show(Article $article){
        return $this->render('blog/show.html.twig',['article'=>$article,]);
    }
  
}
