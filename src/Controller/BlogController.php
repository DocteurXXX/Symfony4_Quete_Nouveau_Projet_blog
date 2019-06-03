<?php
// src/Controller/BlogController.php
namespace App\Controller;



use Doctrine\ORM\Mapping\Entity;
use http\Env\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Tag;
use App\Form\ArticleSearchType;
use App\Form\CategoryType;

class BlogController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     */
    public function home()
    {
        return $this->render('blog/default.html.twig');
    }


    /**
     * @Route("/blog", name="blog_index")
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
            ['articles' => $articles,
            ]
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
     * @Route("/Article/{slug}",
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
     *
     *
     * @Route("/blog/category/{name}",
     *     name="category_show")
     *
     *  @return Response A response instance
     */
    public function showByCategory(Category $category) : Response
    {

       /* if (!$categoryName) {
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

       /* if (!$category) {
            throw $this->createNotFoundException(
                'No article with '.$categoryName.' title, found in article\'s table.'
            );
        }*/

        $article = $category->getArticles();

        return $this->render(
            'blog/category.html.twig',
            [

                'category' => $category,
                'article' => $article,

            ]
        );
    }



    /**
     * @Route("/blog/tag/{name}", name="tag_show")
     * @return Response A response instance
     */
    public function showByTag(Tag $tag) : Response
    {
        $article = $tag->getArticles();

        return $this->render(
            'blog/tag.html.twig',
            [
                'article' => $article,
                'tag' => $tag,
            ]
        );
    }

    /**
     * @Route("/blog/taglist/", name="tag_list")
     * @return Response A response instance
     */
    public function showByTagList() : Response
    {
        $tag = $this->getDoctrine()
        ->getRepository(Tag::class)
        ->findAll();

        return $this->render(
            'blog/taglist.html.twig',
            [
                'tag' => $tag,
            ]
        );
    }


}
