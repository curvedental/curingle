# Curingle

## TODO
* Add documentation to methods for possible auto-documentation in the future.
* Change name of "Factory" classes - aren't factories anymore.
* Scope transition exceptions to the Curingle\Transition namespace.
* Look at using cookies
  (http://docs.guzzlephp.org/en/latest/plugins/cookie-plugin.html)

An interface to Mingle, the project management application.

You will need to create a new instance of MingleClient in and pass it into
Curingle to begin interacting with Mingle. The following creates a client
whose final base URL will be: "https://mingle.mydomain.com/api/v2/projects/foobar"

```php
require_once('vendor/autoload.php');

use Curingle\Curingle;
use Curingle\MingleClient;

$client = MingleClient::Factory(array(
    'base_url' => 'https://mingle.mydomain.com',
    'project' => 'foobar',
    'request.options' => array(
        'auth' => array("USER", "PASSWORD")
    )
));

$curingle = new Curingle($client);
```

Getting a card:

```php
$card = $curingle->card(12345);
```

Getting a transition off for a card:

```php
$transition = $card->transition('Start development');
```

Executing a transition:

```php
$transition->execute();
```

All at once:

```php
$curingle->card(12345)->transition('Start development')->execute();
```

## Transitions

An exception will be thrown when a specified transition isn't available to a
card:

```php
$curingle->card(12345)->transition('Not A Transition');
```

The above will throw an Exception with the message: "No transition matching that
name."

Some transitions require a comment. You can add a comment to a transition using
the `withComment` method:

```php
$curingle->card(12345)->transition('Start development')->withComment('A Comment')
                                                       ->execute();
```

If a transition requires a comment, and one isn't provided, an exception will be
raised.

```php
$curingle->card(12345)->transition('Needs A Comment')->execute();
```

The above will throw an Exception with the message: "This transition requires a
comment."

## Tests

First copy phpunit.xml.dist to phpunit.xml.

The tests are located in the `tests/` directory, and make use of Guzzle's
response mocking facilities. The tests can be run with the following command:

```sh
./script/test.sh
```

## Vim-Syntastic

If you use syntastic for Vim, you might notice that formatting errors on code
that should be formatted correctly. This is because syntastic uses the global
PHP binary as the linter by default and any features new in PHP 5.4 or 5.5 won't
be recognized as valid.

This can be solved by telling syntastic to use the new PHP 5.5 binary as the
linter by adding the following to your ~/.vimrc:

```sh
    let g:syntastic_php_php_exe = '/path/to/php'
```

Alternatively, you can use a project like
[Vim-ProjectLocal](https://github.com/krisajenkins/vim-projectlocal) to load
.vimrc files on a per-project basis. This means that you can have a .vimrc in
the root of your project containing the line above to use that PHP binary as the
linter for that project.
