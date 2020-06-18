<?php

namespace Ndeblauw\BlueAdmin\View\Components\Layout;

use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;

class LeftMenu extends Component
{
    public $menu;
    public $user;

    public function __construct()
    {
        $this->menu = $this->getMenu();
        $this->user = auth()->user() ?? null;
    }

    public function render()
    {
        $itemLoop = 0;
        foreach($this->menu as $item)
        {

            if(! array_key_exists('submenu', $item) && array_key_exists('link', $item) && $item['link'] <> '/admin') {
                if( Request::is(substr($item['link'],1) . '*') ) {
                    $this->menu[$itemLoop]['active'] = true;
                }
            }

            if(! array_key_exists('submenu', $item) && array_key_exists('link', $item) && $item['link'] === '/admin') {
                if( Request::is( substr($item['link'],1)) ) {
                    $this->menu[$itemLoop]['active'] = true;
                }
            }

            if( array_key_exists('submenu', $item) ) {
                $subitemLoop = 0;
                foreach($item['submenu'] as $subitem) {
                    if( Request::is(substr($subitem['link'],1) . '*') ) {
                        $this->menu[$itemLoop]['active'] = true;
                        $this->menu[$itemLoop]['submenu'][$subitemLoop]['active'] = true;
                    }
                    $subitemLoop++;
                }
            }
            $itemLoop++;
        }

        return view('BlueAdminComponents::template.leftmenu');
    }

    public function getMenu()
    {
        return config('blueadmin.menu');
    }
}
