<?php 

namespace App\Controller;

use App\Entity\Coaster;
use App\Form\CoasterType;
use App\Repository\CoasterRepository;
use App\Repository\ParkRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class CoasterController extends AbstractController
{
    // Liste des coasters - Page d'accueil
    #[Route('/coasters', name: 'app_coaster_index')]
    public function index(
        Request $request,
        CoasterRepository $coasterRepository,
        ParkRepository $parkRepository,
        CategoryRepository $categoryRepository
        ): Response
        {
        // Récupérer les paramètres GET
        $parkId = $request->query->get('park', '');
        $categoryId = $request->query->get('category', '');
        $page = (int) $request->query->get('p', 1); // Page actuelle
        $itemsPerPage = 3; // Nombre d'éléments par page
        
        // Appeler la méthode de filtrage avec pagination
        $paginator = $coasterRepository->findFiltered($parkId, $categoryId, $page, $itemsPerPage);
        
        // Calculer le nombre total de pages
        $totalItems = count($paginator); // Le Paginator compte tous les résultats
        $pageCount = (int) ceil($totalItems / $itemsPerPage);
        
        // Récupérer toutes les catégories et parcs pour les selects
        $parks = $parkRepository->findAll();
        $categories = $categoryRepository->findAll();

        return $this->render('coaster/index.html.twig', [
            'coasters' => $paginator,
            'parks' => $parks,
            'categories' => $categories,
            'pageCount' => $pageCount,
        ]);
    }

    // Formulaire d'ajout
    #[Route('/coasters/add', name: 'app_coaster_add')]
    public function add(
        Request $request,
        EntityManagerInterface $em
    ): Response
    {
        $entity = new Coaster();
        $form = $this->createForm(CoasterType::class, $entity);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirectToRoute('app_coaster_index');
        }

        
        return $this->render('coaster/add.html.twig', [
            'coasterForm' => $form,
        ]);
    }

    //(id<d+>) est un paramètre de un ou plusieurs entiers
    #[Route('/coaster/{id<\d+>}/edit', name: 'app_coaster_edit')]
    public function edit(Coaster $entity,
        Request $request,
        EntityManagerInterface $em ): Response
    {
        $form = $this->createForm(CoasterType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_coaster_index');

        }
        return $this->render('coaster/edit.html.twig', [
            'coasterForm' => $form,
        ]);

    }

    #[Route('/{id}/delete', name: 'app_coaster_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Coaster $coaster, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            if ($this->isCsrfTokenValid('delete', $request->request->get('_token'))) {
                $entityManager->remove($coaster);
                $entityManager->flush();
                
                return $this->redirectToRoute('app_coaster_index');
            }
        }
        
        return $this->render('coaster/delete.html.twig', [
            'coaster' => $coaster,
        ]);
    }


}
