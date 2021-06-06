<?php
declare(strict_types=1);

namespace MarcAndreAppel\Laraberg\Contracts;

interface TransformerContract
{
    public function parse(string $html): string;
}
