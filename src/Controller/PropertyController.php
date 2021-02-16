<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    // On partage le tableau dans toute la classe
    private $properties = [
        ['title' => 'Maison avec piscine'],
        ['title' => 'Appartement avec terrasse'],
        ['title' => 'Studio centre ville'],
    ];

/**
* @Route("/property/{page}", name="property_list", requirements={"page"="\d+"})
*
* Page qui liste les annonces immobilières
* Avec requirements, on peut vérifier que page est un nombre
*/
    public function index(Request $request,$page = 1): Response
{
    // Pour démarrer, on va créer un tableau d'annonces
    $properties = $this->properties;

    // Equivalent du var_dump...
    //dump($page);
    // dump($properties);

    $surface = $request->query->get('surface'); //équivaut à $_GET['surface']
    $budget = $request->query->get('budget');
    $size = $request->query->get('size');

    //On prépare un tableau avec la taille des biens
    $sizes = [
        1 => 'Studio',
        2 => 'T2',
        3 => 'T3',
        4 => 'T4',
        5 => 'T5',
    ];



    return $this->render('property/index.html.twig', [
        'properties' => $properties,
        'sizes' => $sizes,
    ]);
}

    /**
     * @Route("/property/{slug}", name="property_show")
*
     * Page qui affiche une annonce avec un paramètre dynamique {slug}
     */
    public function show($slug): Response
{
    // Ici, on peut vérifier que le slug soit dans notre tableau properties
    if (!in_array($slug, array_column($this->properties, 'title'))) {
        // On renvoie une 404 avec Symfony
        throw $this->createNotFoundException();
    }

    return $this->render('property/show.html.twig', [
        'slug' => $slug,
    ]);
}

/**
 * @Route("/property.json", name="property_api")
 */

public function api(): Response{
    //return $this->json($this->properties);
    return new Response(
        json_encode($this->properties)
    );
}



}