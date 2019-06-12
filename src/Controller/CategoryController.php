<?php
// src/Controller/BlogController.php
namespace App\Controller;



use Doctrine\Common\Persistence\ObjectManager;
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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class CategoryController extends AbstractController
{

    /**
     * @Route("/blog/categorylist/", name="category_list")
     * @return Response A response instance
     * @IsGranted("ROLE_ADMIN")
     */
    public function add(\Symfony\Component\HttpFoundation\Request $request, ObjectManager $manager)
    {

        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $category = $form->getData();

            $manager->persist($category);
            $manager->flush();

            $this->addFlash('success', 'Congratulations, a new category has been created');

            return $this->redirectToRoute(
                'category_list'
            );
        }

        return $this->render(
            'blog/categorylist.html.twig', [
                'category' => $categories,
                'form' => $form->createView()
            ]
        );



        /*
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();


        $form = $this->createForm(
            CategoryType::class,
            null,
            ['method' => \Symfony\Component\HttpFoundation\Request::METHOD_GET]
        );

        return $this->render(
            'blog/categorylist.html.twig',
            [
                'category' => $category,
                'form' => $form->createView(),
            ]
        );
        */
    }
}
