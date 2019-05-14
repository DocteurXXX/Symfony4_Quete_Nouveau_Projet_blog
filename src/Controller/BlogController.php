<?php
// src/Controller/BlogController.php
namespace App\Controller;


use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Category;

class BlogController extends AbstractController
{

    /**
     * @Route("/blog", name="blog_index")
     * @Route("/", name="homepage")
     */
    public function index()


    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        return $this->render(
            'blog/index.html.twig',
            ['articles' => $articles]
        );
    }



   /*
   /**
     * @Route("/blog/show/", name="slug_empty_show")
     */
   /*
    public function show_empty()
    {
        return $this->render('blog/show.html.twig', [
            'titre' => 'Article sans Titre'
        ]);
    }*/



    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     *  @return Response A response instance
     */
    public function show(string $slug) : Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with '.$slug.' title, found in article\'s table.'
            );
        }

        return $this->render(
            'blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $slug,
            ]
        );
    }



    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $categoryName The slugger
     *
     * @Route("/blog/category/{categoryName}",
     *     defaults={"categoryName" = null},
     *     name="category_show")
     *  @return Response A response instance
     */
    public function showByCategory(string $categoryName) : Response
    {
        if (!$categoryName) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $categoryName = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($categoryName)), "-")
        );

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneByName($categoryName);


        $article = $category->getArticles();
        /*$article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findByCategory($category);*/




        if (!$category) {
            throw $this->createNotFoundException(
                'No article with '.$categoryName.' title, found in article\'s table.'
            );
        }

        return $this->render(
            'blog/category.html.twig',
            [

                'categoryName' => $categoryName,
                'article' => $article,

            ]
        );
    }

}