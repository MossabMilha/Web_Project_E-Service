<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class FilterSelect extends Component
{
    public string $name;
    public array $options;
    public string $label;
    public string $default;
    public string $formId;

    public function __construct(
        string $name,
        array $options = [],
        ?string $label = null,
        string $default = 'all',
        ?string $formId = null
    ) {
        $this->name = $name;
        $this->options = $options;
        $this->label = $label;
        $this->default = $default;
        $this->formId = $formId;
    }

    public function render(): View|Closure|string
    {
        return view('components.filter-select');
    }
}
