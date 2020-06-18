<?php

namespace Ndeblauw\BlueAdmin\View\Components\Layout;

use Illuminate\View\Component;

class TopbarMenu extends Component
{
    public $topbarMenu;
    public $globalSearch;

    public function __construct($topbarMenu = null, $globalSearch = null)
    {
        $this->topbarMenu = $topbarMenu ?? config('blueadmin.topbarmenu');
        $this->globalSearch = $globalSearch ?? config('blueadmin.globalsearch');
    }

    public function render()
    {
        return view('BlueAdminComponents::template.topbar-menu');
    }
}
