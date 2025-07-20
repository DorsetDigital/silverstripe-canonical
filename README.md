# silverstripe-canonical
Adds a simple rel=canonical tag to Silverstripe

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/DorsetDigital/silverstripe-canonical/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/DorsetDigital/silverstripe-canonical/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/DorsetDigital/silverstripe-canonical/badges/build.png?b=master)](https://scrutinizer-ci.com/g/DorsetDigital/silverstripe-canonical/build-status/master)
[![License](https://img.shields.io/badge/License-BSD%203--Clause-blue.svg)](LICENSE.md)
[![Version](http://img.shields.io/packagist/v/dorsetdigital/silverstripe-canonical.svg?style=flat)](https://packagist.org/packages/dorsetdigital/silverstripe-canonical)

# Requirements
* Silverstripe 6 - Use V3 branch
* Silverstripe 4 / 5 - Use V2 branch

# Installation
* Install the code with `composer require dorsetdigital/silverstripe-canonical`
* Run a `dev/build?flush` to update your project

# Usage
This module adds a simple canonical tag to your pages to allow for the specification of the default domain.  
The canonical tag allows you to signal to search engines like Google which is the authoritative version of the page to help reduce duplicate content issues caused by non-www versions, pages with different protocols, etc.

Once installed, go to the site settings and enter the full canonical domain.   This should include the protocol (e.g. http:// or https://) 

The module tries to be the last extension to be applied, and will try to remove any existing `rel="canonical"` tags from the head.  


At the time of writing, the canonical tags are only added correctly for pages in the SiteTree.   Pages generated from custom controllers or from DataObjects may or may not work!  When creating the canonical tags, the module will look for a method called `CanonicalLink()` on the extended object.  If you are using DataObjects as pages, adding this method on the relevant controller should allow you to control the canonical URL in these cases.

# Additional Credits
* Thanks to @sanderha for the Danish translation
* Thanks to @lerni for his enhancements
* Thanks to @satrun77 for adding CMS 6 support
