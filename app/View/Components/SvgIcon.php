<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SvgIcon extends Component
{
    public $src;
    public $class;
    public $style;
    public $width;
    public $height;
    public $fill;
    public $stroke;

    public function __construct($src, $class = '', $style = '', $width = '1.5em', $height = '1.5em', $fill = 'currentColor', $stroke = 'currentColor')
    {
        $this->src = $src;
        $this->class = $class;
        $this->style = $style;
        $this->width = $width;
        $this->height = $height;
        $this->fill = $fill;
        $this->stroke = $stroke;
    }

    public function render()
    {
        return view('components.svg-icon');
    }
}

