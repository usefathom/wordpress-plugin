=== Fathom Analytics for WP ===
Contributors: convaventures
Tags: analytics, google analytics, privacy, privacy friendly, stats, web analytics, website analytics
Requires at least: 4.5
Tested up to: 6.8.3
Stable tag: 3.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires PHP: 5.4

Fathom is a simple, GDPR compliant Google Analytics alternative.

== Description ==

# The best Google Analytics alternative for WordPress
Fathom Analytics is a simple-to-use, privacy-focused (GDPR-compliant) website analytics tool for your WordPress site. You don’t have to edit the code in your WordPress template to start using our software.

👉 **[Check out our live demo](https://app.usefathom.com/demo) or [sign up for a free 30-day trial](https://app.usefathom.com/register)**.

You’ll need a [subscription](https://app.usefathom.com/register) to Fathom Analytics to start collecting stats with this plugin, and our pricing starts at just $14/month. Instead of generating revenue from your visitors' data, we charge a fair and sustainable price for all our plans. Our business model is privacy-first by design.

## Why use Fathom Analytics?
Google Analytics is time-consuming to use and difficult to understand. Google also kills off its popular software far too often (like Universal Analytics). That’s why Fathom Analytics exists: to make website analytics easy and quick to understand.

Thousands of customers, from governments and banks to small businesses and bloggers, trust their website analytics to Fathom.

### Import from Google Analytics
[We’ve got an importer](https://usefathom.com/features/ga-importer) to save your UA (Universal Analytics) and GA4 data. Because we’ve got unlimited data retention, you can keep and view your stats forever.

### Setup in minutes
Because Fathom Analytics is a [single line of code](https://usefathom.com/docs/script/embed), and our WordPress plugin doesn’t even require any coding, you can go from starting a trial to seeing real-time data within a few minutes. [Learn how to set up our plugin here](https://usefathom.com/docs/integrations/wordpress).

### Comply with privacy laws
The best lawyers and legal minds worldwide regarding digital privacy have ensured that Fathom Analytics is fully compliant with [GDPR, CCPA, ePrivacy, PECR and more](https://usefathom.com/compliance).

### No cookie banners are required
We invented the now industry-standard method for anonymizing visitor data without using cookies. That means you don’t have to clutter your site or slow it down with cookie banner plugins or consent notices for your site’s analytics.

### Email reports
Get a snapshot of your website or websites delivered to your inbox so you can see your critical stats without even having to log into Fathom Analytics. These reports can be set up for any dashboard (or all of them) and sent to anyone (at your company, to your clients, whomever you want).

### Shared or private dashboards
Want to grant access to specific website dashboards for particular clients/employees? Or make your dashboard 100% public? Fathom Analytics lets you create private, public or passworded dashboards without needing an account.

## More features

* Simple options page within WordPress admin
* Ability to not track yourself or specific user roles with a single click
* Search within dashboard boxes
* Tiny, lightweight script that's great for your SEO
* Dark mode
* All sites view to see all your sites at a glance
* And much more

## Setup this WordPress plugin

To learn how to quickly setup this plugin, [read our support doc](https://usefathom.com/docs/integrations/wordpress).


== Installation ==

1. Log into Wordpress
1. Go to `Plugins`, `Add New`
1. Search for `Fathom Analytics for WP`
1. Click `Install Now`, then `Activate`
1. Go to `Settings`, then `Fathom Analytics`
1. Type in your SiteID. If you don’t know your SiteId, log into Fathom, go to `Settings`, `Sites`, then your SiteID will be beside the name of your site
1. If your dashboard is public, leave “Fathom share password” blank. If your dashboard is privately shared, then type in the share password



== Frequently Asked Questions ==

For more details about Fathom, [visit our website](https://usefathom.com) or check out [our documentation](https://usefathom.com/docs).

#### Why isn’t Fathom free like Google Analytics?

If you aren't paying for a product, you are the product. That's why Google Analytics is free, because they make enough money off the personal data their customers give them by using their analytics service. We charge a small and sustainable fee for Fathom because our business model is selling software, not data (these very different business models). Our customers gladly pay for our service because they know their data is safe with us and their visitors' privacy is protected. As a profitable business, we're in this for the long haul.

#### How long do you store my analytics data?

Forever. Meaning, as long as you are a customer, you can access your data all the way back to when you signed up for an account. 7 days, or even 30 days, doesn't give you a clear enough picture of if your website is trending up or down, which is why we give you data retention forever.

#### Can I see a demo?

Of course, our demo can be found here: https://app.usefathom.com/demo

#### How can I get in touch?

See our contact page for details: https://usefathom.com/contact


== Screenshots ==

1. The beautiful Fathom Analytics dashboard
2. The settings field on the general settings page.

== Changelog ==

### 3.3.1 - November 12, 2025

Added the ability to ignore canonical links and tested on latest WordPress version

### 3.3.0 - September 5, 2024

Add cookiebot exclusion to script

### 3.2.4 - September 5, 2024

Add support for WordPress 6.6

### 3.2.3 - June 27, 2024

Added a way for our embed script to be added to OptimizePress pages.

### 3.2.2 - December 18, 2023

PHP 5.6 compatibility fix

### 3.2.1 - November 9, 2023

Additional cache handling for LiteSpeed minification and combining.

### 3.2.0 - November 6, 2023

Added a way to avoid our embed script being minified and combined (which breaks our embed script) in some caching plugins.

#### 3.1.2 - October 26, 2023

Needed NULL not FALSE for wp_enqueue_script, fixed it now, thanks for the patience folks <3

#### 3.1.1 - October 26, 2023

Removed the ?ver from the script.js file as it broke with some caching plugins.

#### 3.1.0 - October 25, 2023

Moved Fathom script from footer to header
Remove custom domain setting (see https://usefathom.com/docs/script/custom-domains)
Add support to exclude logged in users by role from tracking
Added settings link from plugin page

### 3.0.7 - December 9, 2022

Tested on new Wordpress version and updated our graphics for the Wordpress plugin page (well done, Paul, they're beautiful).

### 3.0.6 - April 26, 2022

Fixed a placeholder.

### 3.0.5 - December 7, 2021

Fixed security issue where an administrator could inject XSS code into the Analytics tab and gain access to super administrator accounts on a multi-site installation.

### 3.0.4 - July 12, 2021

Branding and instructions update. Nothing to see here, folks. Hope you're loving the new release of Fathom :)

### 3.0.3 - June 14, 2021

Fixed a bug with custom domains on an older version of PHP

#### 3.0.2 - January 27, 2021

Set the default to track admins, as some users might miss this when installing Fathom for the first time. We also tested the plugin on Wordpress 5.6 and it's working great.

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
