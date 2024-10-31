=== Piwik PRO ===
Contributors: piwikpro, piotrpress
Tags: Piwik PRO, Piwik, analytics, website stats, woocommerce
Requires at least: 5.7
Tested up to: 6.6.1
Stable tag: 1.3.6
Requires PHP: 7.4
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.txt

Adds the Piwik PRO container (with tracking code) to your WordPress site.

== Description ==

A simple plugin to add the [Piwik PRO](https://piwik.pro/) container (with tracking code) to your WordPress site, making it easy to collect visitor data from any WordPress site and automatically track ecommerce in your WooCommerce store. You’ll also be able to manage consents and run tags after using this plugin.

= What is Piwik PRO? =

Piwik PRO is a privacy-first platform that offers the advanced analytics features while allowing for full control of data. It provides flexible reports and data collection in addition to consent management, tag management and a customer data platform.

= Analytics =

Collect data across websites, apps, digital products and post-login areas. Customize how data is collected and analyze it with built-in audience, behavior, acquisition and conversion reports. Dive deeper with custom reports and access to raw data.

= Tag Manager =

Add flexible tags to your analytics stack without hiring an IT team to do it. Quickly create, test and deploy tags from templates or with custom code. Coordinate tag behavior with Analytics, Customer Data Platform and Consent Manager to fit any data collection approach.

= Customer Data Platform =

Build customer profiles, segment audiences and create insightful single customer views. Quickly populate the profiles using data collected with the help of Analytics and Tag Manager. Set up Consent Manager so data is only collected data when there is specific consent for it.

= Consent Manager =

Manage consents and data subject requests in the same platform where data is collected and processed. Categorize data from Analytics and Tag Manager so that the data collected always agrees with the consent received.

== Frequently Asked Questions ==

= Plugin is not working on my site =

Make sure your WordPress theme has the `wp_body_open()` function right after the opening `<body>` tag, otherwise the container won't work.

= What's the difference between the containers? =

* **Basic container (async):** This container holds your tracking code and is used to handle most tags.
* **Additional container (sync):** Add this container if you want to use sync tags. It loads tags before the page content loads.

= WooCommerce: Does this plugin automatically track ecommerce? =

Yes, this plugin automatically tracks events like ecommerce orders and abandoned carts, which result in full ecommerce reporting in Piwik PRO. To see the collected data, just turn on [ecommerce reports](https://help.piwik.pro/support/reports/ecommerce-reports/) in:

`Piwik PRO > Menu > Administration > Reports > Show ecommerce reports.`

= When should I rename the data layer? =

Rename the data layer if you use other software with data layers. If the names are the same, the software can interfere with each other.
To check if your data layer name is not used by other software on your site, follow these steps:

1. In the console on your site, run this command: `!window.hasOwnProperty("customDataLayer");` replacing `customDataLayer` with your custom name.
2. If this command returns `true`, then you can safely use your custom name.

= How to support the Content Security Policy mechanism? =

Content Security Policy restricts third-party tools from loading codes on the website and allows to fetch only approved origins of content. To support Content Security Policy mechanism, you need to add a `nonce` value as an attribute to containers and scripts that these containers load.

To add a `nonce` value add to a `function.php` file in yours theme the following code:

`add_filter( 'piwik_pro_nonce', function() { return wp_create_nonce( time() ); } );`

For more information, read our article about [Content Security Policy](https://developers.piwik.pro/en/latest/tag_manager/content_security_policy.html).

== Installation ==

= From your WordPress Dashboard =

1. Go to **Plugins > Add New**.
2. Search for **Piwik PRO**.
3. Click **Install now**.
4. Click **Activate**.

= From WordPress.org =

1. Download **Piwik PRO** plugin.
2. Upload the **piwik-pro** directory to your `/wp-content/plugins/` directory using ftp, sftp, scp or other method.
3. In your WordPress admin panel, go to **Plugins**.
4. Look for the **Piwik PRO** plugin and click **Activate**.

= Once Activated =

1. Go to **Settings > Piwik PRO**.
2. Type in the **Container address (URL)**.
3. Type in your **Site ID**. [Where to find it?](https://help.piwik.pro/support/questions/find-website-id/)
4. Leave **Basic container (async)** checked. This container holds your tracking code and is used to handle most tags.
5. Check **Additional container (sync)** if you want to add the container for sync tags.
6. Optionally rename the **Data layer**.
7. Click **Save changes**.

= Multisite =

The plugin can be activated and used for just about any use case.

* Activate at the site level to load the plugin on that site only.
* Activate at the network level for full integration with all sites in your network.

== Screenshots ==

1. Settings page

== Changelog ==

= 1.3.6 =
**Release date: 04.09.2024**

* Info: Support for sync container will be discontinued from October 7, 2024.
* Test: Tested up to WordPress 6.6.1

= 1.3.5 =
**Release date: 18.06.2024**

* Add: Added deprecated notice for sync container.

= 1.3.4 =
**Release date: 23.05.2024**

* Fix: Fixed SKU integer value issue by converting it to a string.

= 1.3.3 =
**Release date: 27.03.2024**

* Fix: Fixed performance issue caused by inefficient class autoloader implementation.

= 1.3.2 =
**Release date: 25.10.2023**

* Fix: Fixed wrong product categories array escaping.
* Fix: Removed `<noscript>` tag from the `async` snippet.

= 1.3.1 =
**Release date: 18.10.2023**

* Fix: Fixed PHP Deprecated: `Creation of dynamic property slug is deprecated`.

= 1.3.0 =
**Release date: 26.09.2023**

* Add: Added a turn on/off switch to plugin's settings of `WooCommerce` events.
* Add: Added support for variants in the `name` and `SKU` fields.
* Add: Added support for Piwik PRO's enhanced ecommerce tracking for the `WooCommerce` plugin.
* Fix: Removed deprecated Piwik PRO's ecommerce tracking events for the `WooCommerce` plugin.
* Fix: Prevented tracking of the same order more than once.
* Fix: Fixed PHP Error: `Call to a member function get_cart_contents() on null`.

= 1.2.1 =
**Release date: 06.02.2023**

* Fix: Fixed settings page.

= 1.2.0 =
**Release date: 06.02.2023**

* Add: Added support for `getTrackingSource()` Piwik PRO's event.
* Add: Added support for `trackEcommerceCartUpdate()` and `trackEcommerceOrder()` Piwik PRO's events for `WooCommerce` plugin.
* Fix: Removed `piwik_pro` option in every site in multisite installation during uninstallation.

= 1.1.1 =
**Release date: 06.10.2022**

* Test: Tested up to WordPress 6.0

= 1.1.0 =
**Release date: 05.08.2021**

* Fix: Removed fallback to display async snippet in footer if `wp_body_open()` function is don't implemented in the theme.
* Add: Added `piwik_pro_nonce` filter to enable passing `nonce` variable to scripts.
* Add: Added `nonce` variable to `dataLayer` to enable in sync scripts usage.
* Fix: Changed snippets rendering from files to inline scripts.
* Fix: Updated screenshot file.

= 1.0.2 =
**Release date: 28.04.2021**

* Fix: Removed `delete_option()` from `deactivation()`.

= 1.0.1 =
**Release date: 19.04.2021**

* Fix: Site ID validation.

= 1.0.0 =
**Release date: 16.04.2021**

* First stable version of the plugin.