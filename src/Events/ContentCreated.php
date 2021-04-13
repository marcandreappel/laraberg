<?php
declare(strict_types=1);

namespace MarcAndreAppel\Laraberg\Events;

use Illuminate\Queue\SerializesModels;
use MarcAndreAppel\Laraberg\Models\Content;

class ContentCreated
{
    use SerializesModels;

    public Content $content;

    public function __construct(Content $content)
    {
        $this->content = $content;
    }
}

