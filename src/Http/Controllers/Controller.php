<?php
declare(strict_types=1);

namespace MarcAndreAppel\Laraberg\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function ok(array $data = ['message' => 'ok'], int $code = 200): Response
    {
        return $this->response($data, $code);
    }

    public function notFound(int $code = 404): Response
    {
        return $this->response(['message' => 'not_found'], $code);
    }

    public function response(array $data, int $code): Response
    {
        return response($data, $code)->header('Content-Type', 'application/json');
    }
}
