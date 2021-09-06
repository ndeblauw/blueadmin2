<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Topbar functionalities
    |--------------------------------------------------------------------------
    |
    | globalsearch - Enable or disable the global search // Needs to be implemented
    | messages - Enable or disable the messages // Needs to be implemented
    | notifications - Enable or disable the notifications // Needs to be implemented
    | topbarmenu - Items of the topbar menu
    |
    */

    'globalsearch' => env('BLUEADMIN_GLOBALSEARCH', false),
    'messages' => env('BLUEADMIN_MESSAGES', false),
    'notifications' => env('BLUEADMIN_NOTIFICATIONS', false),

    'topbarmenu' => ['home' => '/', 'dashboard' => '/admin'],

    'fontawesomekit_url' => 'https://kit.fontawesome.com/0bde3bbac3.js',

    'filepond_temporary_files_disk' => 'local',
    'filepond_temporary_files_path' => 'filepond',

    'confirm_delete' => false,
];
