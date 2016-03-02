# Fields

Forms gives you the tools to create your own custom fields. By extending the base `Field` class, your field can be easily used in any form you build. But you still have complete control over how it looks and feels.

Let's work on adding a new type of field together... 

## Creating a field

We're going to create a new type of field to allow the user to submit their age in years. A nice simple example that requires some validation.

### Folder Structure

In the same namespace (or folder) that you created your form in [Step 1](/README.md#step-1), create a folder called `Fields`. For example `path/to/my/app/forms/Fields`. Next, inside the folder we just created, create another folder called `Age` that will contain everything for our new field - like so `path/to/my/app/forms/Fields/Age`.

### Class

Create a class named `Age` that extends `Helmut\Forms\Field`. Save the file at `path/to/my/app/forms/Fields/Age/Age.php`.

```php
// File: path/to/my/app/forms/Fields/Age/Age.php

namespace App\Forms;

class Age extends \Helmut\Forms\Field {
    

}
```

Because you are extending `Helmut\Forms\Field` there will be a few abstract methods that you will need to implement. Let's walk through each one below

1. The `getValue` method returns the current value of the field (fancy that eh?). However we have an empty class, how do we get the value? Well it is up to you to define how the field stores it's current value. In this case we'll add a property to the class to hold the current value and return it using the `getValue` method.

    ```php
        public $value = '';

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

3. The `renderWith` method should return an array of properties that are passed to the template when rendering. This will come in handy when we create the template for this field but for now simply implement an empty method.

    ```php
        public function renderWith()
        {
            
        }
    ```

4. The `setValueFromDefault` method is used to set the current value of the field using the defaults on the parent. By extending `Helmut\Forms\Field` we have access to a `default` property that contains any specified default values. Defauts are specied when your field is created - for example `$form->age('age')->default(18)`. This method is only called if a default has actually been set, so you can be sure that `$this->default` contains a value.

    ```php
        public function setValueFromDefault()
        {
            $this->value = $this->default;        
        }
    ```

