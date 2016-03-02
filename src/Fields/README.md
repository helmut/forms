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

Because you are extending `Helmut\Forms\Field` there will be a few abstract methods that you will need to implement. We'll go through each one below



