<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;
use Closure;

class VisualEditor extends Field
{
    protected string $view = 'forms.components.visual-editor';

    protected int | Closure | null $height = 600;

    public function height(int | Closure | null $height): static
    {
        $this->height = $height;
        return $this;
    }

    public function getHeight(): int
    {
        return $this->evaluate($this->height) ?? 600;
    }
}
