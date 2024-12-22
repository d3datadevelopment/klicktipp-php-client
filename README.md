![stability-wip](https://img.shields.io/badge/stability-work_in_progress-lightgrey.svg) ![GitHub release (latest by date including pre-releases)](https://img.shields.io/github/v/release/d3datadevelopment/klicktipp-php-client?include_prereleases) [![MIT License](https://img.shields.io/github/license/d3datadevelopment/klicktipp-php-client)](https://git.d3data.de/D3Private/klicktipp-php-client/raw/branch/main/LICENSE)

# klicktipp-php-client

An unofficial client for the Klicktipp API.

## Installation
This project can easily be installed through Composer.

```
composer require d3/klicktipp-php-client
```

## Set-up connection
Prepare the client for connecting to Klicktipp with your client key and secret key.

```php
$klicktipp = new \D3\KlicktippPhpClient\Klicktipp(
    $clientkey,
    $secretkey,
    new \GuzzleHttp\Client(...)                             // optional
);
```

## search a subscriber

```php
$subscriberId = $klicktipp->subscriber()->search('me@johndoe.net');
$subscriber = $klicktipp->subscriber()->search($subscriberId);
```

## Supported endpoints (still being added)

[API](https://www.klicktipp.com/de/support/wissensdatenbank/rest-application-programming-interface-api/)

:white_check_mark: = Done, and tested<br />
:ballot_box_with_check: = Done, but not yet tested<br />
:x: = Not yet developed<br />
:heavy_exclamation_mark: = deprecated/not supported <br />

| Endpoint                                                                             | Status                  |
|--------------------------------------------------------------------------------------|-------------------------|
| account                                                                              | :ballot_box_with_check: |
| subscriber                                                                           | :ballot_box_with_check: |
| tag                                                                                  | :ballot_box_with_check: |
