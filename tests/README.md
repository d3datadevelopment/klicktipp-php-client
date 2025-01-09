# Installation

```
composer create-project -s dev --prefer-source [--repository '{"type": "vcs", "url": "repository url"}'] d3/klicktipp-php-client .
```

# Run tests

```
./vendor/bin/phpunit [--no-coverage] [--coverage-html coverage]
```

# Test interface availability

These are not code tests. This call checks the accessibility and availability of the interface endpoints. The account login details are requested to perform these tests.
```
./vendor/bin/phpunit --no-coverage ~/KlicktippApi/tests/availability/
```