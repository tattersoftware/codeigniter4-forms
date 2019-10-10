# Tatter\Forms
RESTful AJAX forms for CodeIgniter 4

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
	> composer require tatter/forms

Or, install manually by downloading the source files and adding the directory to
`app/Config/Autoload.php`.

After installation you will need to publish the required assets to your **public** folder,
as defined by the [manifest files](src/Manifests/):
	php spark assets:publish

> *Tip*: You can add the publish command to your **composer.json**'s `post-update-cmd` section to ensure your assets are always in sync with the package source.

Finally, notify your view/layout of your intention to use the JavaScript for your forms (your paths
may vary):
```
<link href="assets/vendor/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script src="assets/vendor/forms/forms.js" type="text/javascript"></script>
<script src="assets/vendor/bootstrap/bootstrap.bundle.min.js" type="text/javascript"></script>
<script>
	var baseUrl = "<?= base_url() ?>";
	var siteUrl = "<?= site_url() ?>";
	var apiUrl  = "<?= site_url(config('forms')->apiUrl) ?>";
</script>
```

> *Tip*: **Forms** includes [Tatter\Assets](https://github.com/tattersoftware/codeigniter4-assets) which you can use to auto-include assets via the Config file


## Configuration (optional)

The library's default behavior can be overridden or augment by its config file. Copy
**bin/Forms.php** to **app/Config/Forms.php** and follow the instructions in the
comments. If no config file is found the library will use its defaults.

## Usage

*N.B. Please consider this module to be modular itself - you need not use every piece!*
*Treat portions of the code that you do not use as examples for how to implement this in your own app.*

After the initial installation there are a few pieces to implement. **Forms** will run
CRUD-style operations for you by interfacing views with the **ResourcePresenter** or
**ResourceController** depending on the method of interaction (i.e. page load versus AJAX).
Not surprisingly, you will need some **Views** and two **Controllers** per resource.

### Naming

**Forms** interacts with each resource route and controller through that resource's name.
If you are creating a game, your resource names might be *hero(es)*, *level(s)*, *reward(s)*,
etc. The naming convention is important for autoloading resources and their endpoints. By
default, **Forms** will use the name of the model associated with your resource. So a URL of
`heroes/new` would route to the **HeroController** which uses **HeroModel** and the whole
resource would be dubbed **hero** off that model.

If you need to set your own names, do so with your model's `$name` property:
```
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
[examples](examples/Views/) for a full set of example view files.

### Controllers

In addition to the views, you will need two controllers for each resource:
* **Controllers/{names}.php** - Your presenter for page loads, extends `\Tatter\Forms\Controllers\ResourcePresenter.php`
* **Controllers/API/{names}.php** - Your controller for AJAX calls, extends `\Tatter\Forms\Controllers\ResourceController.php`

As with standard framework controllers, your controllers set their model via the `$modelName`
property:
```
<?php namespace App\Controllers;

class Heroes extends \Tatter\Forms\Controllers\ResourcePresenter
{	
	protected $modelName = 'App\Models\HeroModel';
	...
```

Your resource controller can take an additional property, `$format`, to specify response
format (**Forms** currently only supports JSON):
```
<?php namespace App\Controllers\API;

class Heroes extends \Tatter\Forms\Controllers\ResourceController
{	
	protected $modelName = 'App\Models\BookModel';
	protected $format    = 'json';
	...
```

See [RESTful Resource Handling](https://codeigniter4.github.io/userguide/incoming/restful.html)
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

## Appendix

### jQuery

This package uses jQuery because Bootstrap 4 requires it. The Bootstrap team officially
announced plans to remove the jQuery dependency in Bootstrap 5, at which point this package
will transition to native JavaScript (via [Fetch](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API)).
