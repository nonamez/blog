# Change Log
All notable changes made to this project will be documented in this file.

## [0.6.1] - [Unreleased]
### Changed
- Syntax highlight
- The displaying of posts on the main page

## [0.6.0] - [2017-11-03]
### Added
- Markdown
- Syntax highlight

### Changed
- Frawmework upgraded to 5.5.*
- Admin panel moved to Vue
- File handling mechanism

### Deleted
- Portfolio

### Various fixes
### Various optimizations

## [0.5.3] - [Unreleased]
### Added
- Post date

### Changed
- Ordering by post date
- Post permissions moved to scope
- Tags showing from hidden posts

## [0.5.2] - [2017-01-26]
### Fixed
- Syntax Highlight

### Deleted
- Some old files

## [0.5.1] - [2017-01-20]
### Deleted
- Some old files

## [0.5.0] - [2016-12-22]

In the 0.5 version there was minor changes in DB and files while upgrading to 5.3 and improving old stuff so there may be a compatibility problems with previous version. Bassically this version is a new start.

### Added
- Markdown for the posts
- Simple syntax highlight via PHP
- Ability to choose markdaw or raw html for the posts

### Changed
- Improved slug check
- Assets refactored
- Completely rewritten file upload mechanism
- Frawmework upgraded to 5.3.*
- Auth via username

### Fixed
- 404 error
- Lot of small things

## [0.4.0] - [2016-05-12]
### Added
- Portfolio in admin side

### Changed
- User auth info moved to .env
- File usage
- Frawmework upgraded to 5.2.*

## [0.3.5] - [2015-10-29]
### Added
- Slug duplication error when creating post

### Changed
- Default env file

### Fixed
- Redirect after file delete
- Tag creation

## [0.3.4] - [2015-10-15]
### Changed
- Custom configs moved to env

### Fixed
- Ip restrictions

### Removed
- ToDo List

## [0.3.3] - [2015-10-13]
### Added
- Files section

### Changed
- Some improvements
- Personal data

### Fixed
- Top menu

## [0.3.2] - [2015-10-8]
### Changed
- Readme

## [0.3.1] - [2015-10-8]
### Changed
- Some improvements

## [0.3.0] - [2015-10-5]
### Changed
- Updated to Laravel 5.1

## [0.2.1] - [2015-07-06]
### Added
- Header tags cache
- Google Analytics

### Changed
- Blog container width
- "pre" element style

### Fixed
- The ability to display drafts
- Syntax highlighter in Safari

## [0.2.0] - [2015-05-27]
### Added
- Changelog
- Permitted ip check on authorization
- Logout button
- «Bower» and «Gulp» tasks to «Composer»
- Link to the post in the admin

### Changed
- "UserController" to "AuthController"

### Fixed
- The ability to display drafts
- Social share buttons

### Removed
- Aditional parent posts loading
- jQuery in Front-End
- Bootstrap JS in Front-End

## [0.1.0] - [2015-05-19]
### Added
- Authorization
- "CRUD" actions to the post
- File upload