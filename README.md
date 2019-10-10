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
	var apiUrl  = "<?= config('forms')->apiUrl ?>";
</script>
```

> *Tip*: **Forms** includes [Tatter\Assets](https://github.com/tattersoftware/codeigniter4-assets) which you can use to auto-include assets via the Config file


## Configuration (optional)

The library's default behavior can be overridden or augment by its config file. Copy
**bin/Forms.php** to **app/Config/Forms.php** and follow the instructions in the
comments. If no config file is found the library will use its defaults.

## Usage

*Docs coming*

## Appendix

### jQuery

This package uses jQuery because Bootstrap 4 requires it. The Bootstrap team officially
announced plans to remove the jQuery dependency in Bootstrap 5, at which point this package
will transition to native JavaScript (via [Fetch](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API)).
