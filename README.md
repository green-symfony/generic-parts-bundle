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

Open a command console and execute:

### Step 0.1: Install the bundle

```console
	composer require green-symfony/generic-parts-bundle
```

Applications that don't use Symfony Flex (0.2)
--------

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

### Step 2: Enable entry in your base.html.twig

```twig
{% block stylesheets %}
	{{ encore_entry_link_tags('gs_generic_parts') }}
{% endblock %}

{% block javascripts %}
	{{ encore_entry_script_tags('gs_generic_parts') }}
{% endblock %}
```

### Step 3: Add dependency in ***/package.json*** (stimulus controllers)

```php
@green-symfony/generic-parts-stimulus": "file:vendor/green-symfony/generic-parts-bundle/assets/@green-symfony/generic-parts-stimulus
```

### Step 4: Install node_modules of your app

Open a command console and execute:

```console
yarn install --force
```

### Step 5: Register bundle's stimulus controllers in your ***/assets/bootstrap.js***

```js
import { startStimulusApp } from '@symfony/stimulus-bridge';
import { GSWatch } from '@symfony/stimulus-bridge/lazy-controller-loader?lazy=true&export=GSWatch!@green-symfony/generic-parts-stimulus';

export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

/* NOTE:
	twig function {{ stimulus_controller(<>) }} converts '_' -> '-', so register controllers with '-' to avoid problems with finding registered controller
*/

/* ###> ALL THE CONTROLLERS OF THIS BUNDLE ### */
app.register('gs-watch', GSWatch);
/* ###< ALL THE CONTROLLERS OF THIS BUNDLE ### */
```

***In vendor/green-symfony/generic-parts-bundle***
------

### Step 6: Install node_modules of bundle

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
	
Extra Compiler Pass for your ***/vendor/symfony/http-kernel/Kernel.php***
--------

To enable ***monolog.logger.gs_generic_parts.debug*** service when only in concrete APP_ENVs

```php
// /vendor/symfony/http-kernel/Kernel.php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use GS\GenericParts\Pass\{
	GSSetAvailableEnvsForDebugLogger
};

protected function build(ContainerBuilder $container)
{
	$container
		->addCompilerPass(new GSSetAvailableEnvsForDebugLogger(
			appEnv:			$this->getEnvironment(),
			availableEnvs:	['dev'],
		))
	;
}
```
	
To enable sending error messanges of your site when in concrete APP_ENVs

```php
// /vendor/symfony/http-kernel/Kernel.php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use GS\GenericParts\Pass\{
	GSSetAvailableEnvsForEmailErrorLogger
};

protected function build(ContainerBuilder $container)
{
	$container
		->addCompilerPass(new GSSetAvailableEnvsForEmailErrorLogger(
			appEnv:			$this->getEnvironment(),
			availableEnvs:	['prod'],
		))
	;
}
```

Of course you need to add from and to emails of this bundle in file ***/config/packages/gs_generic_parts.yaml***
```yaml
gs_generic_parts:
	error_logger_email:
        from:           '<>'
        to:             '<>'
```