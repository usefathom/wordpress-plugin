Changelog
==========

### 3.0.6 - April 26, 2022

Fixed a placeholder.

### 3.0.5 - Dec 7, 2021

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
