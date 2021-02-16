<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyRealEstateController extends AbstractController
{
    /**
     * @Route("/mes-annonces", name="my_real_estate")
     */
    public function index(): Response
    {
        return $this->render('my_real_estate/index.html.twig', [
            'properties' => $this->getUser()->getRealEstates(),
        ]);
    }
}
