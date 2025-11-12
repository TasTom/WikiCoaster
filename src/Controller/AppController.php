<?php 

namespace App\Controller;
use App\Entity\Coaster;
use App\Form\CoasterType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
Use Symfony\Component\Routing\Attribute\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $entity = new Coaster();
    $form = $this->createForm(CoasterType::class, $entity);
        return $this->render('app/index.html.twig', [
        'coasterForm' => $form,
    ]);
    }
}
