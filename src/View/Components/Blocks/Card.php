<?php

namespace Ndeblauw\BlueAdmin\View\Components\Blocks;

use Illuminate\View\Component;

class Card extends Component
{
    public $col;
    public $headerIcon;
    public $headerTitle;
    public $cardTools;
    public $noPadding;

    public function __construct($title = '', $col = null, $icon = null, $cardTools = null, $noPadding = false)
    {
        $this->col = $col ?? 'col-12 col-md-6';
        $this->headerIcon = $icon;
        $this->headerTitle = ucfirst($title);
        $this->cardTools = $cardTools;
        $this->noPadding = $noPadding ?? '';
    }

    public function render()
    {
        return view('BlueAdminComponents::blocks.card');
    }
}
