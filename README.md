[![Build Status](https://travis-ci.org/roylindauer/royl-wp-theme-base.svg?branch=master)](https://travis-ci.org/roylindauer/royl-wp-theme-base)

# How to include this theme framework in your custom WordPress theme:

Create `composer.json` in your WordPress theme root. 

```
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/roylindauer/royl-wp-theme-base.git"
        }
    ],
    "minimum-stability": "dev",
    "require": {
        "royl/wp-theme-base": "master"
    }
    "require-dev": {

    }
}
```

Run `composer install`

Include the composer autoloader in your functions.php

`include_once __DIR__ . '/vendor/autoload.php';`

Now you can bootstrap your theme:

```
$config = [ ... core config options here ... ];
royl_wp_theme_base( $config );
```

## Configuration

Refer to src/core.php for available configuration options. 

## Purpose

To aid in the creation of WordPress themes. Rapid development of custom post types, taxonomies, and general WordPress config. 

