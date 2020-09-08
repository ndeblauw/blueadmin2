<?php

namespace Ndeblauw\BlueAdmin\View\Components\Layout;

use Illuminate\View\Component;

class TopbarNotifications extends Component
{
    public $notifications;

    public function __construct($notifications = null)
    {
        $this->notifications = $notifications ?? config('blueadmin.notifications');
    }

    public function render()
    {
        return ($this->notifications)
            ? view('BlueAdminComponents::template.topbar-notifications')
            : '';
    }
}
