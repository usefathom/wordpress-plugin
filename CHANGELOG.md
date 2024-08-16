Changelog
==========

### 3.2.4 - August 16, 2024

Added a way to automatically exclude the Fathom script from Cookiebot if the Cookiebot plugin is active.

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

#### 3.0.1 - December 7, 2020

We've had users running into problems when using WP Rocket minification. We spoke to their support team and they advised us on how to exclude the Fathom script from minification. Huge thanks to Jon Henshaw (@henshaw) for initially raising this.

#### 3.0.0 - May 12, 2020

This update includes breaking changes, so please read this message.
1) If you have any manual goals added, you should change them to follow our new guide (see [here](https://usefathom.com/support/goals)). Added new tracking code.
2) You can now exclude your own traffic even when you're logged out, we've added big improvements for custom domains and things are much faster.
3) If you use Fathom Lite, stick to 2.0.4, as you have everything you need

#### 2.0.4 - May 9, 2020

Moved back to the old code as we need a major release due to API changes. We'll get 3.0.0 launched soon.

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
