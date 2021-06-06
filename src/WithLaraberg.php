<?php
declare(strict_types=1);

namespace MarcAndreAppel\Laraberg;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use MarcAndreAppel\Laraberg\Models\Content;

/**
 * @property Content larabergContent
 */
trait WithLaraberg
{
    protected static function bootWithLaraberg(): void
    {
        // Persisting Laraberg editor contents only when the current model has been updated
        self::saved(function ($model) {
            if ($content = $model->larabergContent) {
                $content->contentable()->associate($model)->save();
            }
        });

        // Permanently deleting Laraberg editor content when this model has been deleted
        self::deleted(function ($model) {
            $model->larabergContent()->delete();
        });
    }

    public function larabergContent(): MorphOne
    {
        return $this->morphOne(Content::class, 'contentable');
    }

    public function getEditorCompiledAttribute(): ?string
    {
        if (!$this->larabergContent) {
            return null;
        }

        return $this->larabergContent->compiled_content;
    }

    public function getEditorContentAttribute(): string
    {
        return $this->larabergContent ? $this->larabergContent->render() : '';
    }

    public function setEditorContentAttribute($content): void
    {
        if (! $this->larabergContent) {
            $this->setRelation('larabergContent', new Content);
        }

        $this->larabergContent->setContent($content);
    }

    public function getEditorRawContentAttribute(): string
    {
        if (! $this->larabergContent) {
            return '';
        }

        return $this->larabergContent->raw_content;
    }

}
