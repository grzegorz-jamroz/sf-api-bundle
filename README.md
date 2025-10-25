<h1 align="center">Ifrost Api Bundle for Symfony</h1>

<p align="center">
    <strong>Bundle provides basic features for Symfony Api</strong>
</p>

<p align="center">
    <img src="https://img.shields.io/badge/php->=8.0-blue?colorB=%238892BF" alt="Code Coverage">  
    <img src="https://img.shields.io/badge/coverage-100%25-brightgreen" alt="Code Coverage">   
    <img src="https://img.shields.io/badge/release-v6.3.0-blue" alt="Release Version">   
</p>

# Installation

```
composer require grzegorz-jamroz/sf-api-bundle
```

---

# Development with Docker

### Build and run the containers:
```shell
docker compose up -d
```

### Copy vendor folder from container to host

```shell
docker compose cp app:/app/vendor ./vendor
```

### Run static analysis

```shell
docker compose exec app bin/fix
```

### Run tests

```shell
docker compose exec app bin/test
```

Run single test file:

```shell
docker compose exec app vendor/bin/phpunit --filter <testMethodName> <path/to/TestFile.php>
docker compose exec app vendor/bin/phpunit --filter testShouldReturnExpectedFloat tests/Unit/TransformNumeric/ToFloatTest.php
```

### Enable xdebug

```shell
docker compose exec app xdebug on
```

### Disable xdebug

```shell
docker compose exec app xdebug off
```

# Usage

#### Default config
You can add `config/packages/ifrost_api.yaml` in your project to enable/disable some features if not necessary
```yaml
# config/packages/ifrost_api.yaml
# You can enable/disable some features if not necessary
ifrost_api:
  api_request: true
  exception_listener: true
```
