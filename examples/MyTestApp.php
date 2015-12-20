<?php

class MyTestApp extends Ballen\Clip\ConsoleApplication
{

    const APP_VERSION = "1.0.0";

    /**
     * Instantisate our Console Application and expose the current CLI arguments.
     * @return void
     */
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
