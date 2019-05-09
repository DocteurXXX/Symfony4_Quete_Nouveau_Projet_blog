<?php
// src/Controller/BlogController.php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    /**
     * @Route("/blog", name="blog_index")
     */
    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'owner' => 'Julien',
        ]);
    }


    /**
     * @Route("/blog/show/", name="slug_empty_show")
     */
    public function show_empty()
    {
        return $this->render('blog/show.html.twig', [
            'titre' => 'Article sans Titre'
        ]);
    }


    /**
     * @Route("/blog/show/{titre}", name="slug_show")
     */
    public function show($titre)
    {


        if(preg_match('/[A-Z]/', $titre))
        {
            header('HTTP/1.1 404 Not Found');
            exit();
        }

        elseif(preg_match('/_/', $titre))
        {
            header('HTTP/1.1 404 Not Found');
            exit();
        }

        else {
            $titre = str_replace('-', ' ', $titre);
            $titre = ucwords(strtolower($titre));
        }

        return $this->render('blog/show.html.twig', ['titre' => $titre]);
    }
}