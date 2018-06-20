<?php
namespace DorsetDigital\SilverStripeCanonical;

use SilverStripe\View\HTML;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\CMS\Model\SiteTreeExtension;

class SiteTreeCanonicalExtension extends SiteTreeExtension
{

    public function MetaTags(&$tags)
    {

    $siteConfig = SiteConfig::current_site_config();
    if ($siteConfig->CanonicalDomain != '') {
    $canonicalBase = trim($siteConfig->CanonicalDomain, '/');
    if (method_exists($this->owner, 'CanonicalLink')) {
    $link = $this->owner->CanonicalLink();
    } else {
    $link = $this->owner->Link();
    }
    $canonLink = $canonicalBase . $link;
    $atts = [
        'rel' => 'canonical',
        'href' => $canonLink
    ];
    $canonTag = HTML::createTag('link', $atts);

    $tagsArray = explode(PHP_EOL, $tags);
    $tagPattern = 'rel="canonical"';

    $tagSearch = function ( $val ) use ( $tagPattern ) {
    return ( stripos($val, $tagPattern) !== false ? true : false );
    };

    $currentTags = array_filter($tagsArray, $tagSearch);
    $cleanedTags = array_diff($tagsArray, $currentTags);

    $cleanedTags[] = $canonTag;

    $tags = implode(PHP_EOL, $cleanedTags);
    }
    }
}
