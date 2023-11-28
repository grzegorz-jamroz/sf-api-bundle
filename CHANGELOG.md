# Changelog
## [v6.2.2] - 2023.11.28
### Fix
- [ApiRequest](src/Utility/ApiRequest.php)
  - fix `ifrost_api.api_request` service declaration

## [v6.2.1] - 2023.11.26
### Change
- Update dependencies
  - plain-data-transformer to v1.0.0

## [v6.2.0] - 2023.11.25
### Change
- [ExceptionListener](src/EventListener/ExceptionListener.php)
  - unescaped json in response
  - set default statusCode for response when status code is invalid

### Add
- [SetDataTest](tests/Unit/Utility/ApiRequestTest/SetDataTest.php)
  - add unit tests for method setData in [ApiRequest](src/Utility/ApiRequest.php)
- Configuration
  - add tag `'@ifrost_api.api_request'` for ApiRequest
  - bind default api_request to [ApiRequest](src/Utility/ApiRequest.php)
  - create alias for [ApiRequestInterface](src/Utility/ApiRequestInterface.php) which uses [ApiRequest](src/Utility/ApiRequest.php)

## [v6.1.2] - 2022.12.27
### Change
- [ApiRequest](src/Utility/ApiRequest.php)
  - added fetching data from cookies

## [v6.1.1] - 2022.12.14
### Add
- [ApiRequestInterface](src/Utility/ApiRequestInterface.php)
  - add method setData
- [ApiRequest](src/Utility/ApiRequest.php)
  - add method setData

[v6.2.2]: https://github.com/grzegorz-jamroz/sf-api-bundle/releases/tag/v6.2.2]
[v6.2.1]: https://github.com/grzegorz-jamroz/sf-api-bundle/releases/tag/v6.2.1]
[v6.2.0]: https://github.com/grzegorz-jamroz/sf-api-bundle/releases/tag/v6.2.0]
[v6.1.2]: https://github.com/grzegorz-jamroz/sf-api-bundle/releases/tag/v6.1.2]
[v6.1.1]: https://github.com/grzegorz-jamroz/sf-api-bundle/releases/tag/v6.1.1]
