<?php

namespace App\Entities;

use JsonSerializable;
use CodeIgniter\Pager\Pager;

class PagedData implements JsonSerializable
{
    private array|JsonSerializable $data;
    private int $currentPage;
    private int $perPage;
    private int $totalPages;
    private int $totalItems;
    private bool $hasMore;

    public function __construct(
        Pager $pager,
        array|JsonSerializable $data
    ) {
        $this->data = $data;
        $this->currentPage = $pager->getCurrentPage();
        $this->perPage = $pager->getPerPage();
        $this->totalPages = $pager->getPageCount();
        $this->totalItems = $pager->getTotal();
        $this->hasMore = $pager->hasMore();
    }

    public function jsonSerialize(): mixed
    {
        return [
            'paginaAtual' => $this->currentPage,
            'itensPorPagina' => $this->perPage,
            'totalPaginas' => $this->totalPages,
            'totalItens' => $this->totalItems,
            'temMais' => $this->hasMore,
            'dados' => $this->data,
        ];
    }
}
