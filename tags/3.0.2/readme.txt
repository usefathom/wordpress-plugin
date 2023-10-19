=== Fathom Analytics ===
Contributors: convaventures
Tags: fathom analytics, analytics, website stats
Requires at least: 4.5
Tested up to: 5.6
Stable tag: 3.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires PHP: 5.3

Adds the Fathom tracking snippet to your WordPress site and allows you to embed your Fathom dashboard inside the wordpress admin panel.

== Description ==

A simple plugin to add the [Fathom Analytics](https://usefathom.com/) tracking snippet to your WordPress site. If you are using [Fathom Pro](https://usefathom.com), you can also display a tab that holds the Fathom dashboard, making it easier to see everything in one place.

### What is Fathom?

Fathom Analytics is cutting edge software that tracks users on a website (without collecting personal data) and gives you a non-nerdy breakdown of your top content and top referrers. It does so with user-centric rights and privacy, and without selling, sharing or giving away the data you collect. You can see browsers, countries and devices, and you can also track goals (e.g. form submissions, external link clicks and more).

== Installation ==

1. In your WordPress admin panel, go to *Plugins > New Plugin*, search for **Fathom Analytics** and click "*Install now*"
1. Alternatively, download the plugin and upload the contents of `fathom-analytics.zip` to your plugins directory, which usually is `/wp-content/plugins/`.
1. Activate the plugin


== Frequently Asked Questions ==

#### Where can I find the plugin settings?

This plugin has just a single settings field, which can be found by going to **WP Admin > Settings > General**.

#### Can I use this plugin if I'm using Fathom Lite?

If you're using Fathom Lite, you should use version 2.0.4 of this plugin, as 3.0.0 onwards introduces breaking functionality.


== Screenshots ==

1. The beautiful Fathom Pro dashboard
2. The settings field on the general settings page.

== Changelog ==

#### 3.0.1 - January 27, 2021

Set the default to track admins, as some users might miss this when installing Fathom for the first time. We also tested the plugin on Wordpress 5.6 and it's working great.

#### 3.0.1 - December 7, 2020

We've had users running into problems when using WP Rocket minification. We spoke to their support team and they advised us on how to exclude the Fathom script from minification. Huge thanks to Jon Henshaw (@henshaw) for initially raising this.

#### 3.0.0 - May 12, 2020

This update includes breaking changes, so please read this message.
1) If you have any manual goals added, you should change them to follow our new guide (see [here](https://usefathom.com/support/goals)). Added new tracking code.
2) You can now exclude your own traffic even when you're logged out, we've added big improvements for custom domains and things are much faster.
3) If you use Fathom Lite, stick to 2.0.4, as you have everything you need

#### 2.0.4 - May 9, 2020

Switched it around. A lot of Wordpress sites use goals so we can't use the new API yet, that'll have to come in a major number

#### 2.0.3 - May 9, 2020

We have released brand new tracking code for custom domain users, removed the old fallback and things will now load much faster.

#### 2.0.2 - April 15, 2020

Small fix with version control

#### 2.0.1 - April 15, 2020

What a time to be alive. We have officially added custom domains to Fathom to help with those pesky ad-blockers. And we moved the snippet to the footer (where it escaped from).

#### 2.0.0 - November 15, 2019

Well first of all, we are sorry for the long delay in updating this plugin! We've been busy at work on Fathom V2 all year. In this major update of the wordpress plugin, we've ensured backward compatability but have modified the guidelines to include some of the new changes we have made. Firstly, the concept of a "Dashboard URL" doesn't exist within V2, and you simply use the CDN URL! Nice and easy. But we have left the Dashboard URL in place for our V1 users who self-host. We've also added the ability for V2 users to embed their dashboard & create a new tab in the admin menu.


#### 1.0.1 - October 10, 2018

Added support for tracking multiple sites in a single Fathom dashboard (requires Fathom v1.0.1).


#### 1.0.0 - September 10, 2018

Plugin release.
