# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased](https://git.d3data.de/D3Public/klicktipp-php-client/compare/1.2.0...rel_1.x)

## [1.2.0](https://git.d3data.de/D3Public/klicktipp-php-client/compare/1.1.0...1.2.0) - 2026-01-12
### Changed
- force adding resubscription tag if it's not set
- PHPStan alignment
### Fixed
- don't resubscribe if an unsubscription is present

## [1.1.0](https://git.d3data.de/D3Public/klicktipp-php-client/compare/1.0.3...1.1.0) - 2025-05-20
### Added
- can request optin pending status

## [1.0.3](https://git.d3data.de/D3Public/klicktipp-php-client/compare/1.0.2...1.0.3) - 2025-03-06
### Fixed
- handle different cases in subscribed status

## [1.0.2](https://git.d3data.de/D3Public/klicktipp-php-client/compare/1.0.1...1.0.2) - 2025-02-05
### Added
- reset subscription method

### Changed
- endpoint related task with missing endpoint instance throws an exception instead skipping it

### Fixed
- test for index null values in entities

## [1.0.1](https://git.d3data.de/D3Public/klicktipp-php-client/compare/1.0.0...1.0.1) - 2025-01-13
### Changed
- badges in README

## [1.0.0](https://git.d3data.de/D3Public/klicktipp-php-client/releases/tag/1.0.0) - 2025-01-09
### Added
- support for the following Klicktipp endpoints
  - account
  - field
  - subscriber
  - subscription
  - tag
- entities for all endpoints
- exchangable HTTP client (Guzzle)
- fully tested
- proper exception handling