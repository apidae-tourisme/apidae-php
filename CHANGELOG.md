# Changelog

## Master

## 2019/02/12 - 1.0.3

* update documentation related to "*.apidae-tourisme.com*" and download archive.

## 2017/05/12 - 1.0.2

- change default URLs from "*.sitra-tourisme.com" to "*.apidae-tourisme.com"

## 2016/01/03 - 1.0.1

- manage locales and responseFields default conf in by-id requests
- various documentation updates
- added configuration for SSL behavior

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
