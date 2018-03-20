<?php
namespace DorsetDigital\SilverStripeCanonical;

use SilverStripe\CMS\Model\SiteTreeExtension;
use SilverStripe\View\HTML;

class SiteTreeExtension extends SiteTreeExtension
{

    public function MetaTags(&$tags)
    {
        $canonLink = $this->owner->AbsoluteLink();
        $atts = [
            'rel' => 'canonical',
            'href' => $canonLink
        ];
        $tags .= "\n" . HTML::createTag('link', $atts) . "\n";
    }
}
