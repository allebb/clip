<?php

use Ballen\Clip\ConsoleApplication;

class MyTestApp extends ConsoleApplication
{

    const APP_VERSION = "1.0.0";

    public function __construct($arguments)
    {
        parent::__construct($arguments);
    }

    /**
     * Return the application version number.
     * @return string
     */
    public function version()
    {
        return MyTestApp::APP_VERSION;
    }
}
