<?php

    // Used in a composer context, as a dependance
    if ( file_exists(__DIR__."/../../../autoload.php") )
    {
        require __DIR__."/../../../autoload.php";
        require __DIR__."/../config.inc.php";
    }
    // Used directly from GIT as a test
    elseif ( file_exists(__DIR__."/../vendor/autoload.php") )
    {
        require __DIR__."/../vendor/autoload.php";
        require __DIR__."/../config.inc.php";
    }
    else
        die('no vendor autoload found...') ;