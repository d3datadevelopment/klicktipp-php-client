# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased](https://git.d3data.de/D3Public/klicktipp-php-client/compare/1.0.1...rel_1.x)
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