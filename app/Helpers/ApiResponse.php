<?php

namespace App\Helpers;

use JsonSerializable;
use CodeIgniter\HTTP\ResponseInterface;

class ApiResponse
{
    private static function createResponse(int $status, string $message, JsonSerializable|array $data)
    {
        $body = [
            'cabecalho' => [
                'status' => $status,
                'mensagem' => $message
            ],
            'retorno' => $data
        ];

        return response()
            ->setJSON($body)
            ->setStatusCode($status);
    }

    public static function success(JsonSerializable|array $data, string $message = 'Dados retornados com sucesso')
    {
        return self::createResponse(200, $message, $data);
    }

    public static function updated(JsonSerializable|array|null $data, string $message = 'Recurso atualizado com sucesso'): ResponseInterface
    {
        $status = 200;

        if (is_null($data)) {
            $status = 204;
        }

        return self::createResponse($status, $message, $data);
    }

    public static function noContent(string $message = 'Recurso excluído com sucesso'): ResponseInterface
    {
        $response = self::createResponse(204, $message, []);
        $response->setStatusCode(200);
        return $response;
    }

    public static function created(JsonSerializable|array $data, string $message = 'Recurso criado com sucesso'): ResponseInterface
    {
        return self::createResponse(201, $message, $data);
    }

    public static function unauthorized(string $message = 'Não autorizado'): ResponseInterface
    {
        return self::createResponse(401, $message, []);
    }

    public static function unprocessableContent(JsonSerializable|array $data, string $message = 'Erro de validação'): ResponseInterface
    {
        return self::createResponse(422, $message, $data);
    }

    public static function forbidden(string $message = 'Acesso negado'): ResponseInterface
    {
        return self::createResponse(403, $message, []);
    }

    public static function notFound(string $message = 'Recurso não encontrado'): ResponseInterface
    {
        return self::createResponse(404, $message, []);
    }
}
