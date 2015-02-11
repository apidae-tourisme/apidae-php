# Changelog

## Master

## 2015/02/05 - 1.0.0

- add `exportDir` option to set where the Exports files are stored
- new `cleanExportFiles` method to remove all export files from storage
- add `responseFields` option, set automatically on object list API
- add `locales` option, set automatically on object list API
- add `count` option, set automatically on object list API
- add SSO capabilities:
 - add `ssoBaseUrl`, `ssoRedirectUrl`, `ssoClientId` and `ssoSecret` options
 - new `getSsoUrl` method
 - new `setAccessToken` method
 - new `getSsoToken` API end point
 - new `refreshSsoToken` API end point
- new `getUserProfile` API end point
- new `getUserPermissionOnObject` API end point
- add tests for basic client and metadata

## 2015/01/15 - 0.1.0

- initial release
