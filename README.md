# silverstripe-canonical
Adds a simple rel=canonical tag to Silverstripe 4

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/DorsetDigital/silverstripe-canonical/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/DorsetDigital/silverstripe-canonical/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/DorsetDigital/silverstripe-canonical/badges/build.png?b=master)](https://scrutinizer-ci.com/g/DorsetDigital/silverstripe-canonical/build-status/master)
[![License](https://img.shields.io/badge/License-BSD%203--Clause-blue.svg)](LICENSE.md)
[![Version](http://img.shields.io/packagist/v/dorsetdigital/silverstripe-canonical.svg?style=flat)](https://packagist.org/packages/dorsetdigital/silverstripe-canonical)

# Requirements
*Silverstripe 4.0.x

# Installation
* Install the code with `composer require dorsetdigital/silverstripe-canonical`
* Run a `dev/build?flush` to update your project

# Usage
*This module adds a simple canonical tag to your pages to allow for the specification of the default domain.  
The canonical tag allows you to signal to search engines like Google which is the authoritative version of the page to help reduce duplicate content issues caused by non-www versions, pages with different protocols, etc.

Once installed, go to the site settings and enter the full canonical domain.   This should include the protocol (eg. http:// or https://) 


At the time of writing, the canonical tags are only added correctly for pages in the SiteTree.   Pages generated from custom controllers or from DataObjects may or may not work!