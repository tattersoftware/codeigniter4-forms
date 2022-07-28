# Tatter\Forms
RESTful AJAX forms for CodeIgniter 4

[![](https://github.com/tattersoftware/codeigniter4-forms/workflows/PHPUnit/badge.svg)](https://github.com/tattersoftware/codeigniter4-forms/actions/workflows/phpunit.yml)
[![](https://github.com/tattersoftware/codeigniter4-forms/workflows/PHPStan/badge.svg)](https://github.com/tattersoftware/codeigniter4-forms/actions/workflows/phpstan.yml)
[![](https://github.com/tattersoftware/codeigniter4-forms/workflows/Deptrac/badge.svg)](https://github.com/tattersoftware/codeigniter4-forms/actions/workflows/deptrac.yml)
[![Coverage Status](https://coveralls.io/repos/github/tattersoftware/codeigniter4-forms/badge.svg?branch=develop)](https://coveralls.io/github/tattersoftware/codeigniter4-forms?branch=develop)

## Quick Start

1. Install with Composer: `> composer require tatter/forms`
2. Publish the assets: `> php spark assets:publish`
3. Add the JavaScript to your views

## Features

Provides Resource and Presenter controller templates and corresponding JavaScript for using
AJAX forms with CodeIgniter 4's native RESTful implementation.

## Installation

Install easily via Composer to take advantage of CodeIgniter 4's autoloading capabilities
and always be up-to-date:
```shell
> composer require tatter/forms
```

Or, install manually by downloading the source files and adding the directory to
**app/Config/Autoload.php**.

After installation you will need to copy or publish the required assets to your
**public/** folder. If you want to automate this process check out the
[Assets Library](https://github.com/tattersoftware/codeigniter4-assets).

Finally, notify your view/layout of your intention to use the JavaScript for your forms
(your paths may vary):
```html
<script src="assets/vendor/forms/forms.js" type="text/javascript"></script>
<script>
	var baseUrl = "<?= base_url() ?>";
	var siteUrl = "<?= site_url() ?>";
	var apiUrl  = "<?= site_url(config('forms')->apiUrl) ?>";
</script>
```

## Configuration (optional)

The library's default behavior can be overridden or augment by its config file. Copy
**examples/Forms.php** to **app/Config/Forms.php** and follow the instructions in the
comments. If no config file is found the library will use its defaults.

## Usage

***Note:*** Please consider this module to be modular itself - you need not use every piece!*
*Treat portions of the code that you do not use as examples for how to implement this in your own app.*

After the initial installation there are a few pieces to implement. **Forms** will run
CRUD-style operations for you by interfacing views with the `ResourcePresenter` or
`ResourceController` depending on the method of interaction (i.e. page load versus AJAX).
Not surprisingly, you will need some **Views** and two **Controllers** per resource.

### Naming

**Forms** interacts with each resource route and controller through that resource's name.
If you are creating a game, your resource names might be *hero(es)*, *level(s)*, *reward(s)*,
etc. The naming convention is important for autoloading resources and their endpoints. By
default, **Forms** will use the name of the model associated with your resource. So a URL of
`heroes/new` would route to the `HeroController` which uses `HeroModel` and the whole
resource would be dubbed "hero" off that model.

If you need to set your own names, do so with your model's `$name` property:
```php
class HeroModel extends \CodeIgniter\Model
{
	public $name = 'superhero';
	...
```

### Views

If you choose to use the built-in Controllers they expect the following views to be available
for each resource (where {names} is the plural of your resource name):

* **Views/{names}/new** - Prompt to create a new object, wrapping **{names}/form**
* **Views/{names}/index** - List of all (or filtered) objects, wrapping **{names}/list**
* **Views/{names}/show** - Details of a single object, wrapping **{names}/display**
* **Views/{names}/edit** - Prompt to change an object, wrapping **{names}/form**
* **Views/{names}/remove** - Prompt to remove an object, wrapping **{names}/display** and **{names}/confirm**
* **Views/{names}/list** - Patial view; a list of objects
* **Views/{names}/form** - Patial view; the form used for new and edit
* **Views/{names}/display** - Partial view; a displayable verison of one object
* **Views/{names}/confirm** - Partial view; prompt to delete an object

As you can see **Forms** expects some views that are part of a full page load layout and
some that can be injected into an existing page via AJAX (e.g. in a modal). See
[examples](examples/Views/) for a full set of example view files (note: these are presented
"as is" and may not always be the best solution for all use cases).

### Controllers

In addition to the views, you will need two controllers for each resource:
* **Controllers/{names}.php** - Your presenter for page loads, extends `Tatter\Forms\Controllers\ResourcePresenter`
* **Controllers/API/{names}.php** - Your controller for AJAX calls, extends `Tatter\Forms\Controllers\ResourceController`

As with other framework RESTful controllers, your controllers set their model via the
`$modelName` property:
```php
<?php

namespace App\Controllers;

use App\Models\HeroModel;
use Tatter\Forms\Controllers\ResourcePresenter;

class Heroes extends ResourcePresenter
{	
	protected $modelName = HeroModel::class;
	...
```

Your resource controller can take an additional property, `$format`, to specify response
format (**Forms** currently only supports JSON):
```php
<?php

namespace App\Controllers\API;

use App\Models\HeroModel;
use Tatter\Forms\Controllers\ResourceController;

class Heroes extends ResourceController
{	
	protected $modelName = HeroModel::class;
	protected $format    = 'json';
	...
```

See [RESTful Resource Handling](https://codeigniter.com/user_guide/incoming/restful.html)
in the CodeIgniter 4 User Guide for more info on using resource controllers.

### Routes

You will need to add routes to both controllers for every resource:
```
$routes->presenter('heroes');
$routes->resource('api/heroes', ['controller' => 'App\Controllers\API\Heroes']);

$routes->presenter('rewards');
$routes->resource('api/rewards', ['controller' => 'App\Controllers\API\Rewards']);
```

By default your resource controller routes will all be prefixed "api/", but you can change
this in your config file.

### JavaScript

**Forms** includes a light set of JavaScript commands for passing data between your views
and controllers and auto-handling AJAX requests. If you want a more complete set of functions,
or fully automated object handler you will want to include your own third-party tools and
implement them in your view files.

#### jQuery

This package uses jQuery (not included). Future versions will drop jQuery in favor of
native JavaScript (via [Fetch](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API)).
