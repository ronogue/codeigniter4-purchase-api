<?php

namespace App\Services;

use App\Entities\PagedData;

interface PagenatedInterface
{
    /**
     * @param int $page número da página
     * @param int $perPage quantidade de itens por página
     * 
     * @return PagedData 
     */
    public function getAllPaginated(int $page, int $perPage = 10): PagedData;
}
