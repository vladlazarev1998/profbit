<?php

namespace App\Controller;

use App\Entity\Product;
use App\Utils\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager, Request $request, Paginator $paginator): Response
    {
        $query = $entityManager->getRepository(Product::class)->createQueryBuilder('product');

        $paginator->paginate($query, $request->query->getInt('page', 1), 20);

        return $this->render('home/index.html.twig', [
            'paginator' => $paginator,
        ]);
    }
}
