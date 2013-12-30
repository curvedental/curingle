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

Some transitions require comments. You can pass a string into
Transition::execute that will be added as a comment on a card

```php
$curingle->card(12345)->transition('Start development')->execute('A Comment');
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
