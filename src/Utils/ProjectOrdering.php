<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProjectOrdering
{
    private array $order_by = [
        'code',
        'name',
        'type',
        'price'
    ];

    const DEFAULT_ORDER = 'id';

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly UrlGeneratorInterface $router
    )
    {}

    public function getOrderByKey(?string $column)
    {
        return in_array($column, $this->order_by) ? $column : self::DEFAULT_ORDER;
    }

    public function getSortByKey(?string $key = 'desc')
    {
        return $key === 'desc' ? 'desc' : 'asc';
    }

    public function getLink(string $column): string
    {
        $currentRoute = $this->requestStack->getCurrentRequest()->attributes->get('_route');
        $allParams = $this->requestStack->getCurrentRequest()->query->all();
        $sort = $this->requestStack->getCurrentRequest()->query->get('sort');
        $params = [];

        if (in_array($column, $this->order_by)) {
            $sort_by = $sort === 'desc' ? 'asc' : 'desc';

            $params = array_merge($allParams, [
                'order' => $column,
                'sort' => $sort_by
            ]);
        }

        return $this->router->generate($currentRoute, $params);
    }
}