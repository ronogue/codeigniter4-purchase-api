<?php

namespace App\Services\Clientes;

use App\Services\PagenatedInterface;
use App\Services\CrudServiceInterface;

/**
 * @template T of \App\Entities\Clientes\AbstractCliente
 * @package App\Services\Clientes
 */
interface ClienteServiceInterface extends CrudServiceInterface, PagenatedInterface {}
