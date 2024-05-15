<?php

namespace App\Controller;

use App\Entity\Product;
use App\Utils\Paginator;
use App\Utils\ProjectOrdering;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        EntityManagerInterface $entityManager,
        Request $request,
        Paginator $paginator,
        ProjectOrdering $projectSorting
    ): Response
    {
        $query = $entityManager
            ->getRepository(Product::class)
            ->getQueryOrder(
                $projectSorting->getOrderByKey($request->query->get('order')),
                $projectSorting->getSortByKey($request->query->get('sort'))
            );

        $paginator->paginate($query, $request->query->getInt('page', 1), 20);

        return $this->render('home/index.html.twig', [
            'paginator' => $paginator,
            'projectSorting' => $projectSorting,
        ]);
    }
}
