<?php

namespace App\View\Components;

use Illuminate\View\Component;

/**
 * Class Sidebar
 *
 * @package App\View\Components
 */
class Sidebar extends Component
{
    /** @inheritDoc */
    public function render()
    {
        return view('components.sidebar');
    }
}
