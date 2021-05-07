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
 * @method static where(mixed $string, mixed $id)
 * @property mixed raw_title
 * @property string rendered_content
 * @property string raw_content
 */
class Block extends Model
{
    use HasSlug, WithUuids;

    protected $table = 'laraberg_blocks';
    protected $appends = ['content', 'title'];
    protected $hidden = [
        'created_at',
        'raw_content',
        'raw_title',
        'rendered_content',
        'updated_at'
    ];

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
