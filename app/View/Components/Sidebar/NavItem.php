<?php

namespace App\View\Components\Sidebar;

use Illuminate\View\Component;

/**
 * Class NavItem
 *
 * @package App\View\Components\Sidebar
 */
class NavItem extends Component
{
    public string $name;
    public string $href;
    public bool $isActive;

    public function __construct(string $name, string $href, bool $isActive)
    {
        $this->name = $name;
        $this->href = $href;
        $this->isActive = $isActive;
    }

    /** @inheritDoc */
    public function render()
    {
        return view('components.sidebar.nav-item');
    }
}
