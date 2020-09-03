<?php

namespace Ndeblauw\BlueAdmin\View\Components\Blocks;

use Illuminate\View\Component;

class InfopanelText extends Component
{
    public $value;
    public $label;
    public $link;

    public function __construct($label, $value = null, $link = null)
    {
        $this->label = $label;
        $this->value = $value ?? '/';
        $this->link = $link;
    }

    public function render()
    {
        return view('BlueAdminComponents::blocks.infopanel-text');
    }
}
