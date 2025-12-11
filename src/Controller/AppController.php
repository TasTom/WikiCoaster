<?php

namespace App\Controller;

use App\Repository\CoasterRepository;
use App\Repository\ParkRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        CoasterRepository $coasterRepository,
        ParkRepository $parkRepository,
        CategoryRepository $categoryRepository
    ): Response
    {
        return $this->render('app/index.html.twig', [
            'coaster_count' => count($coasterRepository->findAll()),
            'park_count' => count($parkRepository->findAll()),
            'category_count' => count($categoryRepository->findAll()),
        ]);
    }
}
