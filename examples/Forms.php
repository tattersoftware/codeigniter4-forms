<?php

namespace Config;

/*
*
* This file contains example values to override or augment default library behavior.
* Recommended usage:
*	1. Copy the file to app/Config/Forms.php
*	2. Set any override variables
*	3. Add additional route-specific assets to $routes
*	4. Remove any lines to fallback to defaults
*
*/

class Forms extends \Tatter\Forms\Config\Forms
{
    // Whether to continue instead of throwing exceptions
    public $silent = true;

    // URL base for Resource controllers
    public $apiUrl = 'api/';
}
