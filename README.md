![stability-mature](https://img.shields.io/badge/stability-mature-008000.svg)
![GitHub Tag](https://img.shields.io/github/v/tag/d3datadevelopment/klicktipp-php-client?label=release)
[![MIT License](https://img.shields.io/github/license/d3datadevelopment/klicktipp-php-client)](https://git.d3data.de/D3Public/klicktipp-php-client/raw/branch/main/LICENSE.md)

[![english version](https://logos.oxidmodule.com/en2_xs.svg)](README.md)

# Klicktipp PHP Client

An unofficial client for the Klicktipp API.

## Installation
This project can easily be installed through Composer.

```
composer require d3/klicktipp-php-client
```

## Supported [API endpoints](https://www.klicktipp.com/de/support/wissensdatenbank/rest-application-programming-interface-api/)

:white_check_mark: = Done, and tested<br />
:ballot_box_with_check: = Done, but not yet tested<br />
:x: = Not yet developed<br />
:heavy_exclamation_mark: = deprecated/not supported <br />

- [Account](./src/Resources/Account.php) :white_check_mark:
  - **Login** - create a session with the given credentials
  - **Logout** - terminate an existing session
  - **Get** - request account information and return a property list, use `getEntity` to get a filled [account enitity](./src/Entities/Account.php)
  - **Update** - change account properties


- [Field](./src/Resources/Field.php) :white_check_mark:
  - **Index** - get an [id list of all fields](./src/Entities/FieldList.php)
  - **Get** - load a field and return a property list, use `getEntity` to get a filled [field entity](./src/Entities/Field.php)
  - **Create** - create a new field by given properties
  - **Update** - change field properties
  - **Delete** - delete a defined field


- [Subscriber](./src/Resources/Subscriber.php) :white_check_mark:
  - **Index** - get an [id list of all subscribers](./src/Entities/SubscriberList.php)
  - **Get** - load a subscriber and return a property list, use `getEntity` to get a filled [subscriber entity](./src/Entities/Subscriber.php)
  - **Search** - get the subscriber id by given mail address
  - **Subscribe** - create a new subscriber by given properties
  - **Unsubscribe** - delete a subscriber by its mail address
  - **Tag** - add a tag to the subscriber
  - **Untag** - remove a tag from the subscriber
  - **Tagged** - get an [id list of all active subscribers](./src/Entities/SubscriberList.php) who are tagged with the given tag id
  - **Update** - change subscriber properties
  - **Delete** - delete a defined subscriber
  - **SignIn** - create a subscriber by an external subscription process 
  - **SignOut** - remove a tag or a smart link (defined by an API key) from a subscriber by an external process
  - **SignOff** - unsubscribe a recipient by an external unsubscription process


- [Subscription](./src/Resources/SubscriptionProcess.php) :white_check_mark:
  - **Index** - get an [id list of all subscriptions](./src/Entities/SubscriptionList.php)
  - **Get** - load a subscription and return a property list, use `getEntity` to get a filled [subscription entity](./src/Entities/Subscription.php)
  - **Create** - create a new subscription by given properties
  - **Update** - change subscription properties
  - **Redirect** - returns the URL of the confirmation page of the double opt-in process for the given recipient
  - **Delete** - delete a defined subscription


- [Tag](./src/Resources/Tag.php) :white_check_mark:
  - **Index** - get an [id list of all tags](./src/Entities/TagList.php)
  - **Get** - load a tag and return a property list, use `getEntity` to get a filled [tag entity](./src/Entities/Tag.php)
  - **Create** - create a new tag by given properties
  - **Update** - change tag properties
  - **Delete** - delete a defined tag

## Usage
### Endpoints vs. entities

This library provides access to Klicktipp endpoints as well as more abstract entities of every object.

Endpoints are the raw tools to request Klicktipp transactions which must be combined in many cases to map a task. Often are customized parameters required.

The entities provide easy access to the most properties and offers common preconfigured tasks using the endpoints. All entity modifications are going kept in the object. To submit it to Klicktipp, use the `persist` call.

### Code examples
#### Set-up connection
Prepare the client for connecting to Klicktipp with your client key and secret key.

```php
$klicktipp = new \D3\KlicktippPhpClient\Klicktipp(
    $clientKey,
    $secretKey,
    new \GuzzleHttp\Client(...)    // optional - a customized http client object
);
```

#### Login
```php
$klicktipp->account()->login();
```

#### Use a subscriber

```php
$subscriberId = $klicktipp->subscriber()->search('me@johndoe.net');
$subscriber = $klicktipp->subscriber()->getEntity($subscriberId);
if ($subscriber->isSubscribed()) {
    $subscriber->changeEmailAddress('newMail@domain.tld');
    $subscriber->addTag($tagId);
    $subscriber->persist();  // send collected changes to Klicktipp
}
```
#### Logout

```php
$klicktipp->account()->logout();
```

## Changelog

See [CHANGELOG](CHANGELOG.md) for further information.

## Contributing

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue. Don't forget to give the project a star! Thanks again!

- Fork the Project
- Create your Feature Branch (git checkout -b feature/AmazingFeature)
- Commit your Changes (git commit -m 'Add some AmazingFeature')
- Push to the Branch (git push origin feature/AmazingFeature)
- Open a Pull Request

## Licence
(status: 2025-01-05)

Distributed under the MIT license.

```
Copyright (c) D3 Data Development (Inh. Thomas Dartsch)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
```

For full copyright and licensing information, please see the [LICENSE](LICENSE.md) file distributed with this source code.