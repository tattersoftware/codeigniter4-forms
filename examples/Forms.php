<?php

namespace Config;

use Tatter\Forms\Config\Forms as BaseConfig;

/*
 *
 * This file contains example values to override or augment default library behavior.
 * Recommended usage:
 *	1. Copy the file to app/Config/Forms.php
 *	2. Set any override variables
 *	3. Remove any lines to fallback to defaults
 *
 */

class Forms extends BaseConfig
{
    // URL base for Resource controllers
    public $apiUrl = 'api/';
}
