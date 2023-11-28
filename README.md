<h1 align="center">Ifrost Api Bundle for Symfony</h1>

<p align="center">
    <strong>Bundle provides basic features for Symfony Api</strong>
</p>

<p align="center">
    <img src="https://img.shields.io/badge/php->=8.0-blue?colorB=%238892BF" alt="Code Coverage">  
    <img src="https://img.shields.io/badge/coverage-100%25-brightgreen" alt="Code Coverage">   
    <img src="https://img.shields.io/badge/release-v6.2.2-blue" alt="Release Version">   
</p>

## Installation

```
composer require grzegorz-jamroz/sf-api-bundle
```

#### Default config
You can add `config/packages/ifrost_api.yaml` in your project to enable/disable some features if not necessary
```yaml
# config/packages/ifrost_api.yaml
# You can enable/disable some features if not necessary
ifrost_api:
  api_request: true
  exception_listener: true
```
