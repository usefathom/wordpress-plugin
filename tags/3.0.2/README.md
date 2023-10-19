# Fathom Analytics for WordPress
[![WordPress.org rating](https://img.shields.io/wordpress/plugin/stars/fathom-analytics)](https://wordpress.org/support/plugin/fathom-analytics/reviews)
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

[Fathom Analytics](https://usefathom.com) for WordPress is a simple way to view your dashboard inside WordPress, and add your Fathom Analytics tracking code to your WordPress site without editing any code. This plugin is for paying customers of Fathom Analytics.

![Screenshot of the Fathom Analytics for Wordpress Embedded Dashboard](https://raw.githubusercontent.com/usefathom/wordpress-plugin/master/screenshot-2.png)
![Screenshot of the Fathom Analytics for Wordpress Settings](https://raw.githubusercontent.com/usefathom/wordpress-plugin/master/screenshot-1.png)

### What is Fathom Analytics?
[Fathom Analytics](https://usefathom.com) is a simple, privacy-focused website analytics tool for bloggers and businesses.

Stop scrolling through pages of reports and collecting gobs of personal data about your visitors, both of which you probably don’t need. Fathom is a simple and private website analytics platform that lets you focus on what's important: your business.

Major features of Fathom Analytics include:

* One screen, all the real-time data you need
* Cookie notices not required (we don’t use cookies or collect personal data)
* Displays: top content, top referrers, top goals and more

To use use this plugin, you need have a paid Fathom Analytics account and your dashboard sharing set to [public or private with password](https://usefathom.com/support/sharing).

### FAQ

**Where can I find the plugin settings?**
This plugin has just a single settings field, which can be found by going to WP Admin > Settings > Fathom Analytics.

**Where do I find my SiteID?**
Your SiteID is the unique code in your tracking snippet. Go to your Dashboard, click Settings, then Sites. The SiteID is the second column, copy and paste it from there into the field on the settings page in WordPress.

**What’s the Fathom share password?**
In order to use Fathom Analytics for WordPress your dashboard must be set to “Public” or “Viewable to anyone with the share password”. If your dashboard is public, skip the Fathom Share Password field. If your dashboard is set to have a share password, enter that password in this field.

**What’s the Fathom URL?**
If you have a custom domain, you can enter that and use that. You can read more about that [https://usefathom.com/support/custom-domains](here)

### Usage

Log into Wordpress

1. [Download the Fathom Analytics plugin](https://github.com/usefathom/wordpress-plugin/releases/download/2.0/fathom-analytics.zip)
2. Go to `Plugins`, `Add New`
3. Upload this plugin, `fathom-analytics.zip`
4. Click `Install Now`, then `Activate`
5. Go to `Settings`, then `Fathom Analytics`
6. Type in your `SiteID`. If you don’t know your `SiteId`, log into [Fathom Analytics](https://app.usefathom.com), go to `Settings`, `Sites`, then your `SiteID` will be beside the name of your site
7. If your dashboard is public, leave `Fathom share password` blank. If your dashboard is privately shared, then type in the share password
8. Leave `Fathom URL` set to cdn.usefathom.com

Taking the above steps automatically places the Fathom tracking code into the footer of every page of your WordPress site.

If you now want to see your Fathom dashboard from within Wordpress, make sure “Display Analytics Menu Item” is checked off. Hit Save Changes, and you’ll see Fathom on the menu in WordPress on the lefthand side.

Enjoy Fathom Analytics for WordPress!

### License

GPL-3.0
