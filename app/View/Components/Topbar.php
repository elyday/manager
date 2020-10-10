<?php

namespace App\View\Components;

use Illuminate\View\Component;

/**
 * Class Topbar
 *
 * @package App\View\Components
 */
class Topbar extends Component
{
    /** @inheritDoc */
    public function render()
    {
        return view('components.topbar');
    }
}
