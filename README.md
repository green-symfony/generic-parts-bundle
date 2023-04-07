# generic-parts-bundle

Description
========

Symfony generic parts provide common tools for developing web applicaiton.

Installation
========
Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.


***In your applicaiton***
--------

Applications that use Symfony Flex
--------

Open a command console and execute:

### Step 0.1: Install the bundle

```console
	composer require green-symfony/generic-parts-bundle
```


Applications that don't use Symfony Flex
--------

### Step 0.1: Install the bundle

```console
	composer require green-symfony/generic-parts-bundle
```

### Step 0.2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    <vendor>\<bundle-name>\<bundle-long-name>::class => ['all' => true],
];
```

### Step 1: Add entry in your webpack.config.js

```js
.addEntry('gs_generic_parts', '/vendor/green-symfony/generic-parts-bundle/assets/app.js')
```

### Step 2: Enable entry in your [base.html.twig]

```twig
{% block stylesheets %}
	{{ encore_entry_link_tags('gs_generic_parts') }}
{% endblock %}

{% block javascripts %}
	{{ encore_entry_script_tags('gs_generic_parts') }}
{% endblock %}
```

### Step 3: node_modules of bundle

Open a command console and execute:

```console
yarn install --force
```

### Step 4: Install node_modules dependency (stimulus controllers)

add to the ***package.json***

```php
@green-symfony/generic-parts-stimulus": "file:vendor/green-symfony/generic-parts-bundle/assets/@green-symfony/generic-parts-stimulus
```

***In vendor/green-symfony/generic-parts-bundle***
------

### Step 5: Install all the nesessery node_modules which needs to bundle's js

Open a command console and execute:

```console
yarn install --force
```


Details
========

Basic features for Symfony Web Application which includes:

*Customized services*
- \\Carbon\\CarbonFactory
- \\Faker\\Generator

*Twig*
-	email `base.html.twig` template for sending emails
-	`templates/_placeholder.html.twig` for showing loading

| TwigFilter				| description |
|:--------------------------|:------------|
| gs_trim					| php \trim(<string>) |
| gs_for_user				| return string by \\DateTime or \\DateTimeImmutable object with user locale and timezone |
| gs_array_to_attribute		| convert array to string (not for transform into html attribute, for debugging) |
| gs_binary_img				| return html img with binary image content |

*TwigFunctions*
- gs_dump_array
- gs_lorem
- gs_create_form
- gs_time
- gs_echo
- gs_clear_output_buffer

*TwigComponents*
- gs_alert
- gs_dt
- gs_navs
- gs_sprite	(your should have */public/images/svg/sprite.svg* file)
- gs_submit_button
- gs_watch

*EventSubscribers*
-	kernel.request (for initialize):
	-	php default timezone in UTC
	-	add macros to \\Carbon\\Carbon
-	kernel.exception:
	-	answer or exception of bundle API always measure up to described structure