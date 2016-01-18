# Helmut\Forms

[![Build Status](https://api.travis-ci.org/helmut/forms.svg?branch=master)](https://travis-ci.org/helmut/forms)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

A form abstraction library to simplify processing requests. Think of it as a request model on steroids. We all handle forms in different ways. Forms reduces the complexity and allows you focus on design. Use the default fields types, or build up your own library of reusable and testable fields, and drop them into every application you build.

* [Installation](#installation)
* [Usage](#usage)
* [API Reference](#api-reference)
* [Field Types](#field-types)
	* [Button](#button)
	* [Text](#text)
	* [Name](#user-content-name)
	* [Email](#email)
	* [Number](#number)
	* [Password](#password)
	* [Paragraph Text](#paragraph_text)
	* [Checkbox](#checkbox)
	* [Checkboxes](#checkboxes)
	* [Dropdown](#dropdown)
	* [Search](#search)
* [Customisation](#customisation)
* [Templates](#templates)
* [Language](#language)
* [Plugins](#plugins)
* [Autoloading](#autoloading)
* [Security](#security)
* [License](#license)

## Installation

To get the latest version of Forms, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require helmut/forms
```

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require": {
        "helmut/forms": "~1.0"
    }
}
```

If you are using [Laravel](https://laravel.com) you need to register the service provider. Open up `config/app.php` and add the `Helmut\Forms\Providers\Laravel::class` key to the `providers` array.


## Usage

#### Step 1

Create a class that extends `\Helmut\Forms\Form`.

```php
// File: app/Forms/Form.php

namespace App\Forms;

class Form extends \Helmut\Forms\Form {

}
```
#### Step 2

Now you can create a form.

```php
$form = new \App\Forms\Form;
```

Or in Laravel, simply type hint route or controller methods.

```php
// File: app/Http/routes.php

Route::any('/', function(\App\Forms\Form $form) {

	// Now you can access $form

});
```

#### Step 2

Define fields to build the form.

```php
$form->email('email')->label('Email Address')->required();
$form->password('password')->label('Password')->required();
$form->checkbox('remember')->label('Remember me');
$form->button('login')->label('Sign In');
```

Or alternatively you can create a class just for this specific form that extends `\App\Forms\Form`. Then fields can be defined within a `define` method and they will be added automatically.

```php
// File: app/Forms/Login.php

namespace App\Forms;

class Login extends Form {

	public function define()
	{
		$this->email('email')->label('Email Address')->required();
		$this->password('password')->label('Password')->required();
		$this->checkbox('remember')->label('Remember me');
		$this->button('login')->label('Sign In');
	} 

}
```

#### Step 4

You can now render the form and handle submissions. 

```php
$form = new \App\Forms\Login;

if ($form->completed()) {

	// The form has been submitted and passed validation
}
	
echo $form->render();
```

Or in Laravel:

```php
// File: app/Http/Controllers/LoginController.php

class LoginController extends Controller {
	
    public function handleLoginForm(\App\Forms\Login $form)
    {
    	if ($form->completed()) {

			// The form has been submitted and passed validation

        }

        return view('login.form', compact('form'));
    }

}
```

```
// File: resources/views/login/form.blade.php

@extends('template')

@section('content')

	<h3>Sign In</h3>

    {!! $form !!}

@endsection
```

#### Step 6

<p>Check out the form!</p>

![login](https://cloud.githubusercontent.com/assets/219623/12343804/fd2186e6-bb71-11e5-94fe-2387833554e8.png)

## API Reference

These methods allow you to interact with your form:

```php
	// Fields

	$form->button('register')					// Create a button
	$form->text('foo')							// Create a text field
	$form->name('foo')							// Create a name field
	$form->email('foo')							// Create an email field
	$form->number('foo')						// Create a numeric field
	$form->password('foo')						// Create a password field
	$form->paragraph_text('foo')				// Create paragraph text field
	$form->checkbox('foo')						// Create a checkbox field
	$form->checkboxes('foo')					// Create checkboxes field
	$form->dropdown('foo')						// Create dropdown field
	$form->search('foo')						// Create a search box field

	// Applying Modifiers

	$form->text('foo')->required()				// Make a field required
	$form->text('foo')->default('bar')			// Set a default value
	$form->checkbox('foo')->checked()			// Make it checked
	$form->checkbox('foo')->unchecked()			// Make it unchecked
	$form->dropdown('foo')->options([...])		// Add dropdown options

	// Pre-Filling

	$form->defaults($array)						// Load defaults from an array
	$form->defaults($user, $company, ...)		// Load defaults from model/s

	// Rendering

	$form->render() 							// Generate form
	$form->render('flat') 						// Generate form using flat templates

	// Processing

	$form->valid() 								// Validate the form
	$form->valid('name') 						// Validate a specific field
	$form->invalid() 							
	$form->invalid('name') 						
	$form->submitted() 							// Check if the form has been submitted
	$form->submitted('register') 				// Check if submitted using a specific button
	$form->completed() 							// Check if submitted and valid

	// Retrieving Values

	$form->all() 								// Get all the values
	$form->get('foo') 							// Get the foo field values
	$form->get('foo', 'bar') 					// Get the foo[bar] field value

	// Filling Models

	$form->fill($user) 							// Fills all fields in user model
	$form->fill($user, 'name')	 				// Fills just the name fields
	$form->fill($user, ['name', 'email'])	 	// Fills just the name and email fields

```

## Field Types

* #### button

	```php
	$form->button('foo')->label('Foo')
	$form->submitted('foo') // Returns true if form was submitted using this button
	$form->completed('foo') // Returns true if form both submitted and valid
	```

	![button](https://cloud.githubusercontent.com/assets/219623/12344315/dc723b98-bb76-11e5-98bc-c74a7a63a88b.png)


* #### text

	```php
	$form->text('foo')->label('Foo')->default('bar')->required()
	$form->get('foo') // Returns 'bar'
	```
	Validations: `between(min, max)`, `min(num)`, `max(num)`, `alpha`, `alpha_num`, `alpha_dash`, `in(array)`, `not_in(array)`

	![text](https://cloud.githubusercontent.com/assets/219623/12344320/e7bdb630-bb76-11e5-8ab4-7c43b3a5d680.png)

* #### name

	```php
	$form->name('foo')->label('Foo')->default(['first' => 'Bar', 'surname' => 'Baz'])->required()
	$form->get('foo') // Returns ['foo_first' => 'Bar', 'foo_surname' => 'Baz', 'foo' => 'Bar Baz']
	$form->get('foo', 'surname') // Returns 'Baz'
	```

	![name](https://cloud.githubusercontent.com/assets/219623/12344329/f59dc24a-bb76-11e5-8b7a-1e425130d516.png)

* #### email

	```php
	$form->email('foo') // Same as `text` but with email validation added.
	```

	![email](https://cloud.githubusercontent.com/assets/219623/12344332/fe70fbd0-bb76-11e5-9671-ee8624f2e3fa.png)

* #### number

	```php
	$form->number('foo')->label('Foo')->default('123')->required()
	$form->get('foo') // Returns '123'
	```
	Validations: `between(min, max)`, `min(num)`, `max(num)`, `integer`, `in(array)`, `not_in(array)`

	![number](https://cloud.githubusercontent.com/assets/219623/12344336/072ce306-bb77-11e5-8668-e707780cf166.png)

* #### password

	```php
	$form->password('foo')->label('Foo')->required()
	$form->get('foo') // Returns 'hashed_bar'
	$form->password('foo')->matches('other_hash') // Returns true/false
	```

	![password](https://cloud.githubusercontent.com/assets/219623/12344346/10c30bf2-bb77-11e5-8b0b-45cf661ae126.png)

* #### paragraph_text

	```php
	$form->paragraph_text('foo')->label('Foo')->default('bar')->required()
	$form->get('foo') // Returns 'bar'
	```

	![paragraph_text](https://cloud.githubusercontent.com/assets/219623/12344352/1a29823e-bb77-11e5-9b29-48ee4a80a975.png)

* #### checkbox

	```php
	$form->checkbox('foo')->label('Foo')->required()
	$form->checkbox('foo')->checked() // Check the box
	$form->checkbox('foo')->unchecked() // Uncheck the box
	$form->get('foo') // Returns true/false
	```

	![checkbox](https://cloud.githubusercontent.com/assets/219623/12344357/229b2526-bb77-11e5-8bde-54f4a4a9c30e.png)

* #### checkboxes

	```php
	$form->checkboxes('foo')->label('Foo')->options(['bar' => 'Bar', 'baz' => 'Baz'])->required()
	$form->checkboxes('foo')->checked() // Check all the boxes
	$form->checkboxes('foo')->checked(['bar']) // Check some of the boxes
	$form->checkboxes('foo')->unchecked() // Uncheck all the boxes
	$form->checkboxes('foo')->unchecked(['baz']) // Uncheck some of the boxes
	$form->get('foo') // Returns ['foo_bar' => false, 'foo_baz' => false]
	```

	![checkboxes](https://cloud.githubusercontent.com/assets/219623/12344360/2af0dbb2-bb77-11e5-9008-bfd02d3969ed.png)

* #### dropdown

	```php
	$form->dropdown('foo')->label('Foo')->options(['bar' => 'Bar', 'baz' => 'Baz'])->default('baz')->required()
	$form->get('foo') // Returns 'baz'
	```

	![dropdown](https://cloud.githubusercontent.com/assets/219623/12344363/324a1c66-bb77-11e5-9963-bba7909fe8e7.png)

* #### search

	```php
	$form->search('foo')
	$form->get('foo') // Returns ['foo' => 'bar', 'foo_button' => true]	
	```

	![search](https://cloud.githubusercontent.com/assets/219623/12344366/3a4153ee-bb77-11e5-89cd-30f0ced0ea11.png)

## Customisation

Forms was designed as a framework upon which developers can build a library of modules that can simplify the repetitive task of processing complex requests.

Field types, templates, languages and plugins are included, however the expectation is that you will use those as a starting point for customisation. By rolling your own, you can design, build and test them once, and drop them into any application. To start customising, follow these steps. 

In the same namespace (or folder) that you created your form in [Step 1](#step-1):

* Create a folder called `Fields`. Then put each of your own custom field types into that folder. For example `App\Forms\Fields\Toggle` where `Toggle` is the name of your new field. Learn how to [create a field](src/Fields/).

* Create a folder called `templates`. Then place your custom template package into that folder. For example `App\Forms\templates\flat` where `flat` is the name of your package. Templates can be rendered by specifying the engine in the filename extension. For example `themes/flat/template.mustache.php` will use the [Mustache](http://mustache.github.io/) engine. [Twig](http://twig.sensiolabs.org/) and [Blade](http://laravel.com/docs/blade) are also available. Learn how to make [templates](src/templates/).

* Create a `lang` folder. 

* Create a `Plugins` folder. More information about [plugins](src/Plugins/).


## Templates

A few basic template packages are provided by default that are compatible with common css frameworks including [Bootstrap](http://getbootstrap.com/), [Foundation](http://foundation.zurb.com/), [Jeet](http://github.com/mojotech/jeet), [Singularity](https://github.com/Team-Sass/Singularity) and [Neat](https://github.com/thoughtbot/neat). These should provide a great base for [customisation](#customisation).

```php
$form->setTemplate('bootstrap') 		// Default
$form->setTemplate('foundation')
$form->setTemplate('jeet')
$form->setTemplate('singularity')
$form->setTemplate('neat')
```

## Language

```php
$form->setLanguage('en') 	// Set language to english
$form->setLanguage('es') 	// Idioma establecida en español
```

## Plugins

```php
$form->addPlugin('feedback');   // Instant validation feedback
$form->addPlugin('memory');   // Autosave as you type
```

## Autoloading

By extending `\Helmut\Forms\Form`, all of your custom fields, templates, languages and plugins will be loaded automatically. Your files will always be preferenced over the defaults, so feel free to make copies of them and modify them to fit your application. 

## Security

If you discover any security related issues, please email helmut.github [at] gmail.com instead of using the issue tracker. All security vulnerabilities will be promptly addressed.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
