# Templates

In the same namespace (or folder) that you created your form in [Step 1](/README.md#step-1), create a folder called `templates`. For example `path/to/my/app/forms/templates`.

This is where you will build your custom template packages. For example `path/to/my/app/forms/templates/flat` where `flat` is the name of your package. 

You can also override an existing template by simply copying the package folder from the vendor directory. For example, copy `vendor/helmut/forms/src/templates/bootstrap` to `path/to/my/app/forms/templates/bootstrap` and then make your desired modifications.

Template files can be rendered by specifying the engine in the filename extension. For example `path/to/my/app/forms/templates/flat/form.mustache.php` will use the [Mustache](http://mustache.github.io/) engine. [Twig](http://twig.sensiolabs.org/) and [Blade](http://laravel.com/docs/blade) are also available. 

So that fields can be simply dropped in, each one has it's own `templates` directory. See [creating fields](/src/Fields/).