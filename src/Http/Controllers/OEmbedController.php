<?php
declare(strict_types=1);

namespace MarcAndreAppel\Laraberg\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use MarcAndreAppel\Laraberg\Helpers\EmbedHelper;

class OEmbedController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $embed = EmbedHelper::create($request->url);
        $data  = EmbedHelper::serialize($embed);

        if ($data['html'] == null) {
            return $this->notFound();
        }

        return $this->ok($data);
    }
}
