# Changelog

## v3.4.1 (2024-05-24)

### What's fixed
- Rewrite a needlessly complex line that prevented favicons to be generated when using local SSL. aaadbafe by @robdekort

## v3.4.0 (2024-04-19)

### What's new
- Support Statamic v5. #13 by @robdekort

## v3.3.3 (2023-12-09)

### What's improved
- Delay generating favicons to prevent race condition issues. ba8116e6 by @robdekort

## v3.3.2 (2023-11-28)

### What's improved
- Prettier routes. #11 by @marcorieser

## v3.3.1 (2023-11-27)

### What's fixed
- Register site.webmanifest routes with site specific URL. #10 by @marcorieser

## v3.3.0 (2023-11-24)

### What's new
- The ability to use different favicons per (multi)site. #8 by @marcorieser
- Localizable favicon fields. 77738088 by @robdekort

## v3.2 (2023-07-03)

### What's new
- Ability to utilize the favicons disk for generating and saving favicons. #6 by @sandergo

## v3.1.1 (2023-06-14)

### What's fixed
- Fix error in webmanifest file. a503c1d1 by @robdekort

## v3.1 (2023-06-14)

### What's new
- Add `name` property to webmanifest. babf2ff6 by @robdekort

## v3.0 (2023-06-14)

### What's changed
- Remove old and deprecated meta tags and settings. #4 by @robdekort
- Put all PWA icons in webmanifest. #4 by @robdekort
- Add standalone display toggle. #4 by @robdekort
- Add Browser Appearance update script so your site will make use of the new config automatically. #4 by @robdekort

## v2.0 (2023-05-09)

**Breaking changes**: If you upgrade an existing site make sure to apply the [changes made to Peak Core in v12](https://github.com/studio1902/statamic-peak/releases/tag/v12.0).

### What's new
- Statamic v4 support by splitting fieldsets into sections. #2 by @robdekort

## v1.0 (2022-02-09)

- Initial release.
