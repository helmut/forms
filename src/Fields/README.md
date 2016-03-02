# Fields

Forms gives you the tools to create your own custom fields. By extending the base `Field` class, your field can be easily used in any form you build. But you still have complete control over how it looks and feels.

Let's work on adding a new type of field together... 

## Creating a field

We're going to create a new type of field to allow the user to submit their age in years. A nice simple example that requires some validation. Usage of this new field will be as easy as `$form->age('age')->label('Age')`. Let's get started!

### Folder Structure

In the same namespace (or folder) that you created your form in [Step 1](/README.md#step-1), create a folder called `Fields`. For example `path/to/my/app/forms/Fields`. Next, inside the folder we just created, create another folder called `Age` that will contain everything for our new field - like so `path/to/my/app/forms/Fields/Age`.

### Class

Create a class named `Age` that extends `Helmut\Forms\Field`. 

```php
// File: path/to/my/app/forms/Fields/Age/Age.php

namespace App\Forms\Fields\Age;

use \Helmut\Forms\Field;

class Age extends Field {
    

}
```

Because you are extending `Helmut\Forms\Field` there will be a few abstract methods that you will need to implement. Let's walk through each one below

1. The `getValue` method returns the current value of the field (fancy that eh?). It is up to you to define how the field stores it's current value. In this case we'll add a property to the class to hold the current value and return it using the `getValue` method.

    ```php
    protected $value = '';

    public function getValue()
    {
        return $this->value;
    }
    ```

2. The `getButtonName` method returns the name of any keys that are associated with buttons that can submit the form. As this field does not contain any buttons we don't have to do anything other than implement an empty method.

    ```php
    public function getButtonName()
    {
        
    }
    ```

3. The `renderWith` method should return an array of properties to be passed to the template when rendering. The only property we have at the moment is value so let's just return that. Other properties such as `id`, `form_id`, `name`, `type`, `label`, `required`, `valid` and `invalid` status are included automatically.

    ```php
    public function renderWith()
    {
        return ['value' => $this->value];
    }
    ```

4. The `setValueFromDefault` method is used to set the current value of the field using any defaults that have been set. By extending `Helmut\Forms\Field` we have access to a `default` property that contains any specified default values. Defauts are specied when your field is created - for example `$form->age('age')->default(18)`. This method is only called if a default has actually been set, so you can be sure that `$this->default` contains a value.

    ```php
    public function setValueFromDefault()
    {
        $this->value = $this->default;        
    }
    ```

4. The `setValueFromModel` method is used to set the current value of the field using a model. So to implement this method we really just want to check if the passed in model has the same name property as the field and then set the value accordingly. The name of our field is a property of the parent class and can be retrieved using `$this->name`.

    ```php
    public function setValueFromModel($model)
    {
        if (property_exists($model, $this->name)) $this->value = $model->{$this->name};
    }  
    ```

5. The `setValueFromRequest` method is used to set the current value of the field using the request object. Fetch the value for this field out of the request (using the name again) and set it. 

    ```php
    public function setValueFromRequest($request)
    {
        $this->value = $request->get($this->name);
    }  
    ```

6. The `fillModelWithValue` method is the opposite of the `setValueFromModel`. Take this field's value and fill the matching property of the model with it.

    ```php
    public function fillModelWithValue($model)
    {
        if (property_exists($model, $this->name)) $model->{$this->name} = $this->value;
    }  
    ```

7. The `validate` method is called every time the field is validated. All validation methods need to return a boolean value. Return true if the validation passes and false if it fails. For many fields there is default validation needed so you can simply return true. However in this case we want make sure the response is always numeric and greater than zero.

    ```php
    public function validate()
    {
        return  is_numeric($this->value) && $this->value > 0;
    }  
    ```

8. The `validateRequired` method is the only other validation that you are forced to implement. We can just check that the value property is not empty.

    ```php
    public function validateRequired()
    {
        return ! empty($this->value);
    }  
    ```

So your full `Age` class should look like this:

```php
namespace App\Forms\Fields\Age;

use \Helmut\Forms\Field;

class Age extends Field {

    protected $value = '';

    public function getValue()
    {
        return $this->value;
    }

    public function getButtonName()
    {

    }

    public function renderWith()
    {
        return ['value' => $this->value];
    }

    public function setValueFromDefault()
    {
        $this->value = $this->default;
    }

    public function setValueFromModel($model)
    {
        if (property_exists($model, $this->name)) $this->value = $model->{$this->name};
    }

    public function setValueFromRequest($request)
    {
        $this->value = $request->get($this->name);
    }

    public function fillModelWithValue($model)
    {
        if (property_exists($model, $this->name)) $model->{$this->name} = $this->value;
    }
    
    public function validate()
    {
        return  is_numeric($this->value) && $this->value > 0;
    }

    public function validateRequired()
    {
        return ! empty($this->value);
    }    

    public function validateMin($min)
    {
        return $this->value >= $min;
    }    

}
```

### Template

Create a folder called `templates` for your age field - `path/to/my/app/forms/Fields/Age/templates`. Then create a subfolder with the same name as your theme. So if we are using the default theme, the folder will be called `bootstrap` - `path/to/my/app/forms/Fields/Age/templates/bootstrap`.

Add a new template file named `age.mustache.php`. Templates can be rendered by specifying the engine in the filename extension. For example `age.mustache.php` will use the [Mustache](http://mustache.github.io/) engine. [Twig](http://twig.sensiolabs.org/) and [Blade](http://laravel.com/docs/blade) are also available. 

```
// File: path/to/my/app/forms/Fields/Age/templates/bootstrap/age.mustache.php

<div class="row">
    <div class="col-sm-12">
        <div class="form-group" style="margin-bottom:10px">
            <label>{{ label }}{{# required }} <span style="font-weight:normal" title="{{ lang.required }}">*</span>{{/ required}}</label>
            <input name="{{ name }}" value="{{ value }}" type="text" class="form-control" style="width:25%">
        </div>
    </div>
</div>
```

As you can see, you have full control over how the field is rendered.

### Try it out

We're almost finished! But let's try out this new age field before we continue.

```php
// Build the form
$form = new App\Forms\Form;

// Define the new field
$form->age('age')->label('Age')->required();

// Render
echo $form->render();
```

![age](https://cloud.githubusercontent.com/assets/219623/13453897/b9848252-e0a7-11e5-9c81-eafa13dd8d67.png)


### Additional Validation

Don't forget that we also needed to be able to have the option of setting a minimum. For example `$form->age('age')->label('Age')->min(21)`. To create a `min(21)` validation we need to add a `validateMin` method to our `Age` class. All validation methods must be prefixed with the word validate.

```php
public function validateMin($min)
{
    return $this->value >= $min;
}
```

Format the error message within a language file. Create a folder called `lang` for your age field - `path/to/my/app/forms/Fields/Age/lang`. Then create a file for english called `en.php` - `path/to/my/app/forms/Fields/Age/lang/en.php`. The error message will be picked up automatically.

```php
return [
    'validate_min' => 'The [field] field must be a minimum of [min].',
];
```

As you can see, it works!

![age-error](https://cloud.githubusercontent.com/assets/219623/13455802/b678f046-e0b3-11e5-9d26-43d84d690e31.png)

