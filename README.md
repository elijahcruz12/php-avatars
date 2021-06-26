# PHP Avatars
Generate avatars quickly and easily through one simple to use class.

PHP Avatars was created with one VERY simple goal in mind, to be able to generate a URL for avatars, without memorizing the options that Avatar generators and providers such as Gravatar and UI Avatars provide.

COMING SOON: I will be adding built-in integration to Laravel, which will allow you to use a Facade to generate the URLs.

## Requirements

There are ZERO requirements, other than needing PHP, needing Componser, and the website you're wanting to add PHP Avatars to. That's it.

## Install

Installing is as simple as requiring it in Composer.

````
composer require elijahcruz/avatars
````

## Usage

Using PHP Avatars is made to be very simple, however even though it's very simple, it has the ability to enable you to do everthing that each provider normally should allow you to do. For example, set the default in Gravatar, or set the background and color in UI Avatars.

Basic Example:

````
use Elijahcruz\Avatars\Avatar;

$avatar = new Avatar('johndoe@example.com')

$avatar->getUrl();

````

This is all is takes to load the users Gravatar. However, you can also have options as well. And there are multiple ways to do this:

````
// Through initialization
$avatar = new Avatar('johndoe@example.com', 'gravatar', ['default' => 'mp', 'size' => 200]);

// Using the option() method

$avatar->option('size', 200);

// Add multiple using the options() method
$avatar->options(['default' => 'mp', 'size' => 200]);
````

As you may have noticed, when initializing PHP Avatar, the 2nd parameter is which generator you are using. You can also specify which type using it's method:

````
// Using Gravatar
$avatar->gravatar();

// Using UI Avatars
$avatar->uiavatars();
````

This allows you to switch between avatar generators quickly and easily. But what if each one uses different options, or you wanted to generate the URL again, but with a different size, no problem. Any options that aren't defined in the generator your currently using are ignored. Any that are, can be overwritten.

````
// Create an option then rewrite it
$avatar->option('size', 200); // Size is 200
$avatar->option('size', 400); // Size is now 400
````

You can also reset all options to a blank slate using the resetOptions() method. If you add an array to this, it will reset the array then add those options to it.

````
// Reset the options, but maybe redefine them later?
$avatar->resetOptions()

// Reset and change the options
$avatar->resetOptions(['size' => 400]);
````

But what if you wanted to also change from using an email, to the person's name, so UI Avatars shows an actual name? No problem. Just use the newIdentifier() method;

````
$avatar->newIdentifier('John Doe');
````

The best part about all of this? They can be chained!

````
$avatar->option('size', 200)->option('default' , 'mp')->option('rating', 'pg')->gravatar()->getUrl();
````

This is what makes PHP Avatars super simple, but VERY powerful.

This is all is takes to easily manage your avatars for your users.

# Currently Supported Proviers

Meanwhile there are so many options in terms of providers out there, we're working on making as many as possible work with PHP Avatars, to give you the best possible package for this. Each provider's own options that they provide are included in PHP Avatars, to make things VERY simple.

## Gravatar

Options:

| Option          | Type   | Accepts                                                        |
|-----------------|--------|----------------------------------------------------------------|
| 'default'       | string | mp, 404, identicon, monsterid, wavatar, retro, robohash, blank |
| 'force_default' | bool   | true, false                                                    |
| rating          | string | g, pg, r, x                                                    |
| size            | int    | Any integer                                                    |
| extension       | string | .jpg                                                           |