Silverstripe Middleman
======================

Module that acts as a connector for framework only modules, allowing them to
benefit from CMS Code (such as $SiteConfig, $Menu etc).

This is intended to help with framework only modules that might be added to a
CMS installed site.

## Usage

Currently this module is designed to allow you to provide additional
functionality to your controllers by providing Content Controller methods via
an extension class.

You can add these methods by extending your controller, either in _config.php

    Your_Controller::add_extension("Middleman_Controller");

Or in your config.yml

    Your_Controller:
      extensions:
        - Middleman_Controller
