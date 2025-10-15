<?php 

namespace App\Controller;
use App\Entity\Coaster;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
Use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;


class CoasterController extends AbstractController
{
    #[Route('/coasters', name: 'coasters')]
    public function add(EntityManagerInterface $em): Response
    {
        $entity = new Coaster();
        $entity->setName('Blue Fire');
        // ...

        $em->persist($entity); // Ajoute l'entité dans le manager
        $em->flush(); // Exécute les requêtes

        return new Response('Coaster ajouté');
    }
}