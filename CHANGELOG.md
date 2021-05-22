0.7.3	|	Release date: **22.05.2021**
============================================
* New Features:
* Bug-Fixes:
  - Fix LoggableListener when not versioned entity is submited.
  - Fix LoggableListener when translatable has not id yet.


0.7.2	|	Release date: **17.05.2021**
============================================
* Improvements:
  - AbstractCrudController make classInfo protected to can get from child controllers.


0.7.1	|	Release date: **17.05.2021**
============================================
* New Features:
  - Override Gedmo LogEntryRepository to make revert by locale possible.
  - Make Entity Loggable Versioning depends on Locale.


0.7.0	|	Release date: **17.05.2021**
============================================
* New Features:
  - Add Vaersioning of Translatable fields.
  - Add LogEntry Model.


0.6.12	|	Release date: **10.05.2021**
============================================
* Bug-Fixes:
  - Fix MenuBuilder to resolve parameters in uri's


0.6.11	|	Release date: **09.05.2021**
============================================
* Bug-Fixes:
  - Set Parameter 'vankosoft_host' to can get from vs_app.menu_builder service.


0.6.10	|	Release date: **07.05.2021**
============================================
* Bug-Fixes:
  - Remove typehints of the properties of the class  Component/Settings/Settings.


0.6.9	|	Release date: **30.04.2021**
============================================
* New Features:
  - Change namespace of the console commands to vankosoft.


0.6.8	|	Release date: **30.04.2021**
============================================
* New Features:
  - Send inMaintenance variable to twig when render MaintenancePage.


0.6.7	|	Release date: **29.04.2021**
============================================
* New Features:
  - MaintenanceListener Render MaintenancePage with layout.


0.6.6	|	Release date: **28.04.2021**
============================================
* Bug-Fixes:
  - Fix MaintenanceListener because the user is not always object but and not an object.


0.6.5	|	Release date: **24.04.2021**
============================================
* New Features:
  - Add Form Labels Translations.


0.6.4	|	Release date: **23.04.2021**
============================================
* Bug-Fixes:
  - RE-Fix :( EasyUI Combotree Source to get with leafs.


0.6.3	|	Release date: **23.04.2021**
============================================
* Bug-Fixes:
  - RE-Fix :( EasyUI Combotree Source to get set checked values.


0.6.2	|	Release date: **22.04.2021**
============================================
* New Features:
  - Create a TaxonomyHelperTrait for additin Taxonomy/Taxons Actions.


0.6.1	|	Release date: **22.04.2021**
============================================
* New Features:
  - Add Move Functionality of Taxons.


0.6.0	|	Release date: **20.04.2021**
============================================
* New Features:
  - Create Taxons Abstraction to create EasyUI Tree with leafs.


0.5.20	|	Release date: **20.04.2021**
============================================
* Bug-Fixes:
  - Fix Supressing PDO Exceptions.


0.5.19	|	Release date: **20.04.2021**
============================================
* New Features:
  - Add Option to can Supress PDO Exceptions.


0.5.18	|	Release date: **19.04.2021**
============================================
* Bug-Fixes:
  - Fix EasyUI Combotree Source to get set checked values.


0.5.17	|	Release date: **19.04.2021**
============================================
* New Features:
  - Add Taxonomy tree data trait a method to get  EasyUI Combotree with selected.


0.5.16	|	Release date: **19.04.2021**
============================================
* Bug-Fixes:
  - Fix TaxonomyTreeDataTrait to return combotree data without root taxon.


0.5.15	|	Release date: **17.04.2021**
============================================
* Bug-Fixes:
  - Fix Taxon ORM Mapping.


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


