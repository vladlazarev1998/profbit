<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InformationController extends AbstractController
{
    #[Route('/information', name: 'information')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $data = $entityManager->getRepository(Product::class)->getGroupedData();

        $groupedData = [];
        foreach ($data as $item) {
            $code = $item['code'];
            if (!isset($groupedData[$code])) {
                $groupedData[$code] = [
                    'total_count' => 0,
                    'total_price' => 0,
                    'types' => [],
                ];
            }
            $groupedData[$code]['total_count'] += $item['count'];
            $groupedData[$code]['total_price'] += $item['total_price'];
            $groupedData[$code]['types'][] = $item;
        }

        uasort($groupedData, function ($a, $b) {
            return $b['total_count'] - $a['total_count'];
        });

        return $this->render('information/index.html.twig', [
            'groupedData' => $groupedData,
        ]);
    }
}
