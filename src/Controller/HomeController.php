<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{
    /**
     * Undocumented function
     *
     * @Route("/hello/{prenom}", name="hello")
     */
    public function hello($prenom)
    {
        return new Response("Bonjour...". $prenom);
    }
    /**
     * @Route("/", name="homepage")
     *
     * 
     */
    public function home()
    {
        return $this->render(
            'home.html.twig',
            ['title' => "hello tchach"]

        );
    }
}