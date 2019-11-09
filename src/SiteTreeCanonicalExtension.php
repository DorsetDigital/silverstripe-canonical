<?php
namespace DorsetDigital\SilverStripeCanonical;

use SilverStripe\View\HTML;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\CMS\Model\SiteTreeExtension;

class SiteTreeCanonicalExtension extends SiteTreeExtension
{
    private static $db = [
        'CanonicalURL' => 'Text'
    ];
    
    public function updateCMSFields(FieldList $fields) {
        $MetaToggle = $fields->fieldByName('Root.Main.Metadata');
        if ($url = $this->getorsetCanonicalURL()) {
            $MetaToggle->push($MetaCanonical = TextField::create('CanonicalURL', _t(__CLASS__ . '.LinkOverride',"Override canonical URL")));
            $MetaCanonical
                ->setAttribute('placeholder', $this->getorsetCanonicalURL())
                ->setDescription(_t(__CLASS__ . '.LinkOverrideDesc','Only set this if search engines should count another URL as the original (e.g. if re-posting a blog post from another source).'));
        } else {
            $MetaToggle->push($MetaCanonical = LiteralField::create("CanonicalURL", '<p class="form__field-label">' . _t(__CLASS__ . '.LinkFieldPlaceholder','Canonical-URLs benötigt eine Canoinical-Domain in <a href="/admin/settings">SiteConfig</a>') . '</p>'));
        }
        $MetaCanonical->setRightTitle(_t(__CLASS__ . '.LinkFieldRightTitle','Used to identify the original resource (URL) so that content is not considered "duplicate content". Internal & external links can be used.'));
    }

    function getorsetCanonicalURL() {
        $siteConfig = SiteConfig::current_site_config();
        if (filter_var($siteConfig->CanonicalDomain, FILTER_VALIDATE_URL)) {
            $canonicalBase = trim($siteConfig->CanonicalDomain, '/');

            // dynamic value
            if (method_exists($this->owner, 'CanonicalLink')) {
                $link = $this->owner->CanonicalLink();
            }

            // canonical link on Page
            if (isset($this->owner->CanonicalURL)) {
                // $link = $this->owner->CanonicalURL;
            }

            // add canonicalBase if relative URL
            if (isset($link)) {
                $urlArray = parse_url($link);
                if (!isset($urlArray['host']) && !isset($urlArray['scheme'])) {
                    $canonicalBase = $urlArray['scheme'] . '://' . $urlArray['host'];
                    $link = $canonicalBase . $link;
                }
            } else {
                // default link with base
                $link = $canonicalBase . $this->owner->Link();
            }

            return $link;
        }
    }

    public function MetaTags(&$tags)
    {
        if ($canonLink = $this->getorsetCanonicalURL()) {
            $atts = [
                'rel' => 'canonical',
                'href' => $canonLink
            ];
            $canonTag = HTML::createTag('link', $atts);

            $tagsArray = explode(PHP_EOL, $tags);
            $tagPattern = 'rel="canonical"';

            $tagSearch = function($val) use ($tagPattern) {
                return (stripos($val, $tagPattern) !== false ? true : false);
            };

            $currentTags = array_filter($tagsArray, $tagSearch);
            $cleanedTags = array_diff($tagsArray, $currentTags);

            $cleanedTags[ ] = $canonTag;

            $tags = implode(PHP_EOL, $cleanedTags);
        }
    }
}
