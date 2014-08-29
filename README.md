[![Build Status](https://travis-ci.org/josegonzalez/cakephp-purifiable.png?branch=master)](https://travis-ci.org/josegonzalez/cakephp-purifiable) [![Coverage Status](https://coveralls.io/repos/josegonzalez/cakephp-purifiable/badge.png?branch=master)](https://coveralls.io/r/josegonzalez/cakephp-purifiable?branch=master) [![Total Downloads](https://poser.pugx.org/josegonzalez/cakephp-purifiable/d/total.png)](https://packagist.org/packages/josegonzalez/cakephp-purifiable) [![Latest Stable Version](https://poser.pugx.org/josegonzalez/cakephp-purifiable/v/stable.png)](https://packagist.org/packages/josegonzalez/cakephp-purifiable)

# Purifiable

Sanitize model data easily

## Background

Someone on #cakephp had an issue with PHP timing out. Normally, I’d say it was just bad coding, but it’s probably just a bad practice on their part. The issue they had is with HTML Purifier. I built this behavior to make sanitizing data a bit simpler.

## Requirements

* CakePHP 2.x
* PHP 5.3

## Installation

_[Using [Composer](http://getcomposer.org/)]_

Add the plugin to your project's `composer.json` - something like this:

```composer
	{
		"require": {
			"josegonzalez/cakephp-purifiable": "dev-master"
		}
	}
```

Because this plugin has the type `cakephp-plugin` set in its own `composer.json`, Composer will install it inside your `/Plugins` directory, rather than in the usual vendors file. It is recommended that you add `/Plugins/Purifiable` to your .gitignore file. (Why? [read this](http://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md).)

_[Manual]_

* Download this: [http://github.com/josegonzalez/cakephp-purifiable/zipball/master](http://github.com/josegonzalez/cakephp-purifiable/zipball/master)
* Unzip that download.
* Copy the resulting folder to `app/Plugin`
* Rename the folder you just copied to `Purifiable`

_[GIT Submodule]_

In your app directory type:

```bash
	git submodule add -b master git://github.com/josegonzalez/cakephp-purifiable.git Plugin/Purifiable
	git submodule init
	git submodule update
```

_[GIT Clone]_

In your `Plugin` directory type:

		git clone -b master git://github.com/josegonzalez/cakephp-purifiable.git Purifiable

### Enable plugin

In 2.0 you need to enable the plugin in your `app/Config/bootstrap.php` file:

		CakePlugin::load('Purifiable');

If you are already using `CakePlugin::loadAll();`, then this is not necessary.

## Usage

## TODO

## License

The MIT License (MIT)

Copyright (c) 2010 Jose Diaz-Gonzalez

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
