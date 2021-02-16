<?php

namespace App\Controller;

use App\Repository\RealEstateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/api/search/{query}", name="api_search")
     */
    public function index($query = '', RealEstateRepository $repository): Response
    {
        $realEstates = $repository->search($query);
      return $this->json([
          //'results' => $realEstates,
          'html' => $this->renderView('real_estate/_real_estate.html.twig',[
              'properties' => $realEstates
          ]),
      ]);
    }
}
