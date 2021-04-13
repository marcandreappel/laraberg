<?php
declare(strict_types=1);

namespace MarcAndreAppel\Laraberg\Models;

use Illuminate\Database\Eloquent\Model;
use MarcAndreAppel\Laraberg\Helpers\BlockHelper;
use MarcAndreAppel\Laraberg\Helpers\EmbedHelper;
use MarcAndreAppel\LaravelUuids\Uuids;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @method static where(string $string, string $id)
 */
class Block extends Model
{
    use HasSlug, Uuids;

    protected $table = 'laraberg_blocks';
    protected $appends = ['content', 'title'];
    protected $hidden = [
        'created_at',
        'raw_content',
        'raw_title',
        'rendered_content',
        'updated_at'
    ];

    private string $raw_content;
    private string $rendered_content;

    public function render(): string
    {
        return BlockHelper::renderBlocks($this->rendered_content);
    }

    public function renderRaw(): string
    {
        $this->rendered_content = EmbedHelper::renderEmbeds($this->raw_content);
        return $this->rendered_content;
    }

    public function setContent(string $content): void
    {
        $this->raw_content = $content;
        $this->renderRaw();
    }

    public function getContentAttribute(): array
    {
        return [
            'raw' => $this->raw_content,
            'rendered' => $this->rendered_content,
            'protected' => false,
            'block_version' => 1
        ];
    }

    public function getTitleAttribute(): array
    {
        return [
            'raw' => $this->raw_title,
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('raw_title')
            ->saveSlugsTo('slug');
    }
}
