<?php


namespace App\Controller;

use App\Repository\RealEstateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
//AbstractController est le fichier qui regroupe toutes les fonctions utile par défaut
{
    /**
     * @Route("/hello", name="hello")
     * /hello est l'url de la page
     */


    // On renvoie toujours un objet Response
    //Ici on précise la balise body pour avoir la toolbar
    public function hello(){
         $name = 'symfony';
        // return new Response('<html><body>Hello symfony</body></html>');
        // render renvoie une response , la page
        return $this->render('Welcome/hello.html.twig',[
            //'name' => 'Symfony',
            'name' => $name,
            ]);
    }

    /**
     * @Route("/", name="homepage")
     */
    public function home(RealEstateRepository $realEstateRepository): Response{

        $last3Product = $realEstateRepository->FindLastThreeID();

        return $this->render('welcome/home.html.twig',[
            'last3ID' => $last3Product,
        ]);
    }
}