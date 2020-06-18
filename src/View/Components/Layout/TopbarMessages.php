<?php

namespace Ndeblauw\BlueAdmin\View\Components\Layout;

use Illuminate\View\Component;

class TopbarMessages extends Component
{
    public $messages;

    public function __construct($messages = null)
    {
        $this->messages = $messages ?? config('blueadmin.messages');
    }

    public function render()
    {
        return ($this->messages)
            ? view('BlueAdminComponents::template.topbar-messages')
            : '';
    }
}
