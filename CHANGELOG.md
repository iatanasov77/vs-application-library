0.5.14	|	Release date: **17.04.2021**
============================================
* Improvemets:
  - Taxonomy form set current locale selected.


0.5.13	|	Release date: **16.04.2021**
============================================
* Bug-Fixes:
  - Some Fix.


0.5.12	|	Release date: **16.04.2021**
============================================
* Bug-Fixes:
  - Fix SettingsManager:saveSettings method.


0.5.11	|	Release date: **16.04.2021**
============================================
* Bug-Fixes:
  - May be fix.


0.5.10	|	Release date: **16.04.2021**
============================================
* Improvements:
  - Centralize settings cache file for all sites.


0.5.9	|	Release date: **16.04.2021**
============================================
* Bug-Fixes:
  - Fix SettingsManager Bug.


0.5.8	|	Release date: **16.04.2021**
============================================
* Improvements:
  - Improvements and Debug option in the MaintenanceModeCommand.


0.5.7	|	Release date: **16.04.2021**
============================================
* Bug-Fixes:
  - Fix SettingsManager bug.


0.5.6	|	Release date: **16.04.2021**
============================================
* Bug-Fixes:
  - Fix SettingsManager bug.


0.5.5	|	Release date: **16.04.2021**
============================================
* Improvements:
  - Use PhpArrayAdapter as CacheAdapter in the SettingsManager because it allow to share settings between applications. For Example between web and cli.


0.5.4	|	Release date: **16.04.2021**
=============================================
* Bug-Fixes:
  - SettingsManager bug.


0.5.3	|	Release date: **16.04.2021**
============================================
* Bug-Fixes:
  - Tne MaintenaceModeCommand has not been added into services


0.5.2	|	Release date: **16.04.2021**
============================================
* New Features:
  - Add CLI Command to force Maintenance Mode.


0.5.1	|	Release date: **16.04.2021**
============================================
* New Features:
  - SettingsManager add option to clear the all of cached items.


0.5.0	|	Release date: **16.04.2021**
============================================
* New Features:
  - Add Settings Manager to generalize site settingsand use it from cache.


0.4.5	|	Release date: **15.04.2021**
============================================
* Some Additions:
  - Using Imagine and user profile picture in the layout top template.
  - Add templates/views for Settings but not made to works ;).


0.4.4	|	Release date: **13.04.2021**
============================================
* Bug-Fixes:
  - Fix SettingsController and SettingsExtController for right processing of form handling.


0.4.3	|	Release date: **13.04.2021**
============================================
* Bug-Fixes:
  - Fix SettingsController bug.


0.4.2	|	Release date: **13.04.2021**
============================================
* Improvements:
  - Fix SettingsController to pass multiple forms to the template when have multisite application.


0.4.1	|	Release date: **13.04.2021**
============================================
* Bug-Fixes:
  - Fix Settings Repository to get Settings when site is NULL.


0.4.0	|	Release date: **12.04.2021**
============================================
* New Features:
  - Create Resource 'Site' and relate it to Settings Resource.


0.3.0	|	Release date: **07.03.2021**
============================================
* Improvements, Fixes and Refactoring:
  - Update composer.json
  - Refactoring Site Settings Models.
  - Fix Taxons gtreetable source.
  - Add Taxonomy TreeData Trait for reuse purposes.
  - Use siteid as sevices parametter to get settings for concrete site.
  - Remove language from Settings model.
  - Remove language from Settings model.
  - Fix ThemeChangeListener.
  - Adding templates for login and dashboard. Adding Auth and Dashboard controllers.
  - Fix UserLocaleSubscriber.
  - Fix of doctrine-mapping.
  - Fixes and Improvements of Taxonomy and Taxons.
  - VS Application Translatable Entities. Fix Taxonomies.
  - Theme Settings and Theme Loader.


0.2.0	|	Release date: **20.01.2021**
============================================
* New Features:
  - Add AbstractCrudController to use of other bundles.


0.1.0	|	Release date: **20.01.2021**
============================================
* First release. In general this bundle should manage:
  - multi-site environement.
  - multi-language support.
  - select theme and language for site.
  - maintenance mode management.
  - taxonomies


