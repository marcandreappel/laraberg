<?php
declare(strict_types=1);

namespace MarcAndreAppel\Laraberg\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use MarcAndreAppel\Laraberg\Models\Block;

class BlockController extends Controller
{
    protected Block $blockModel;

    public function __construct()
    {
        $this->blockModel = config('laraberg.models.block');
        $this->blockModel = new $this->blockModel;
    }

    public function index(): Response
    {
        $blocks = $this->blockModel->all();

        return $this->ok($blocks);
    }

    public function store(Request $request): Response
    {
        $block = $this->blockModel;

        $block->raw_title = $request->get('title');
        $block->status    = $request->get('status');
        $block->setContent($request->getContent());
        $block->updateSlug();
        $block->save();

        return $this->ok($block->toJson(), 201);
    }

    public function show(Request $request, string $id): Response
    {
        $block = $this->blockModel->where('id', $id);

        if (!$block) {
            return $this->notFound();
        }

        return $this->ok($block);
    }

    public function update(Request $request, string $id): Response
    {
        $block = $this->blockModel->where('id', $id);

        if (!$block) {
            return $this->notFound();
        }

        $block->raw_title = $request->get('title');
        $block->status    = $request->get('status');
        $block->setContent($request->getContent());
        $block->updateSlug();
        $block->save();

        return $this->ok($block);
    }

    public function destroy(string $id): Response
    {
        $block = $this->blockModel->where('id', $id);

        if (!$block) {
            return $this->notFound();
        }
        $block->delete();

        return $this->ok();
    }
}
