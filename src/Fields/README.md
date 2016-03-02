# Fields

Forms gives you the tools to create your own custom fields. By extending the base `Field` class, your field can be easily used in any form you build. But you still have complete control over how it looks and feels.

Let's work on adding a new type of field together... 

## Creating a field

We're going to create a new type of field to allow the user to submit their `Age` in years. A nice simple example that requires a touch of validation and templating.

### Folder Structure

Before we get started, in the same namespace (or folder) that you created your form in [Step 1](/README.md#step-1), create a folder called `Fields`. For example `path/to/my/app/forms/Fields`. Next let's create a folder called `Age` that will contain our new field inside the folder we just created - like so `path/to/my/app/forms/Fields/Age`.

## The Field Class

Now that you have set up a folder for your field we need to create a new class called `Age` that extends `Helmut\Forms\Field`.

```php
// File: path/to/my/app/forms/Fields/Age/Age.php

namespace App\Forms;

class Age extends \Helmut\Forms\Field {
    

}
```

