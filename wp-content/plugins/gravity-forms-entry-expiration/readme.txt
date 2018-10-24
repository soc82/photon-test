=== Entry Expiration for Gravity Forms ===
Contributors: travislopes, forgravity
Tags: gravity forms, entry, expiration
Requires at least: 3.9.2
Tested up to: 4.7.5
Stable tag: 4.7.3

Automatically remove old form entries on a custom, defined schedule

== Description ==

> #### [Entry Automation for Gravity Forms](https://forgravity.com/plugins/entry-automation/?utm_source=wordpress&utm_medium=readme&utm_campaign=readme) makes entry deletion more powerful and allows you to export your entries too!
>
> Entry Expiration started out as a simple tool to automatically remove your old form entries. But what if you need more control over when entries are deleted? Want to apply conditional logic to target specific entries? Need to generate an export file before getting rid of those entries?
> 
> [Check out Entry Automation](https://forgravity.com/plugins/entry-automation/?utm_source=wordpress&utm_medium=readme&utm_campaign=readme) today!


When integrating Gravity Forms with a third-party service, it's often not necessary to keep entries around after a short period of time as you already have the data imported elsewhere.

Entry Expiration for Gravity Forms allows you to automatically delete Gravity Forms entries older than a defined timeframe. After activating the plugin, set the oldest age for an entry on the Entry Expiration Settings page. At midnight, the plugin will delete all entries on enabled forms that are older than the time you set.

== Installation ==
= Requirements =
* WordPress version 3.9.2 and later (tested at 4.7.5)
* Gravity Forms 1.8.17 and later

= Installation =
1. Unpack the download package.
1. Upload all files to the `/wp-content/plugins/` directory, with folder
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to the Form Settings page for each form you want to have entries automatically expire and click the 'Entry Expiration' tab.
1. Define how often you want entries to be deleted and the minimum age required for entries to be deleted.

== Changelog ==
= v2.0.5 =
* Fix PHP notices.

= v2.0.4 =
* Added capabilities.
* Updated installation instructions.

= v2.0.3 =
* Fixed search criteria not correctly preparing in certain scenarios.

= v2.0.2 =
* Fixed search criteria not correctly preparing the search end date.

= v2.0.1 =
* Fixed fatal error during 2.0 upgrade process.

= v2.0 =
* Added expiration time and recurrence at the form level.
* Rewrote expiration procedure to be more efficient.

= v1.2.3 =
* Added additional logging
* Added filter for setting entry expiration time for each form

= v1.2.2 =
* Changed plugin loading method
* Added "gf_entryexpiration_recurrence" hook to change cron recurrence

= v1.2.1 = 
* Adjusted entry older than date to not be relative to midnight

= v1.2 = 
* Fixed update routine to not automatically enable forms for processing if running a fresh install
* Changed expiration time setting to allow choosing between hours, days, weeks and months

= v1.1 =
* Switched forms from being able to be excluded to having to include them for processing
* Deletion cron now runs hourly instead of daily
* Cron now only deletes 1000 entries at a time to prevent long execution times
* Added filters for: payment status, number of entries to be processed at a time

= v1.0 =
* Initial release