# PHP Model
A PHP model interface

[![Build Status](https://travis-ci.org/sideshowcecil/php-model.svg?branch=master)](https://travis-ci.org/sideshowcecil/php-model)

## Installation

The suggested installation method is via [composer](https://getcomposer.org/):

```sh
php composer.phar require "sideshow_bob/model:~1.0.0"
```

## Usage

The project provides interfaces that allow to model databases or HTTP API endpoints easily.
As an example we have added an implementation for the [Redmine API](http://www.redmine.org/projects/redmine/wiki/Rest_api) based on the [Redmine Client](https://packagist.org/packages/kbsali/redmine-api) by kbsali.
The example can be found in the `examples` directory.
