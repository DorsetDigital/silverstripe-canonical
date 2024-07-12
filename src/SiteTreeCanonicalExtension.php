<?php

namespace DorsetDigital\SilverStripeCanonical;

use SilverStripe\View\HTML;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\CMS\Model\SiteTreeExtension;
use SilverStripe\CMS\Model\VirtualPage;

class SiteTreeCanonicalExtension extends SiteTreeExtension
{
    private static $db = [
        'CanonicalURL' => 'Text'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        if ($MetaToggle = $fields->fieldByName('Root.Main.Metadata')) {
            if ($url = $this->getorsetCanonicalURL()) {
                $MetaToggle->push($MetaCanonical = TextField::create('CanonicalURL', _t(__CLASS__ . '.LinkOverride', "Override canonical URL")));
                $MetaCanonical
                    ->setAttribute('placeholder', $this->getorsetCanonicalURL())
                    ->setDescription(_t(__CLASS__ . '.LinkOverrideDesc', 'Only set this if another URL should count as the original (e.g. of reposting a blog post from another source).'));
                if ($this->owner->ClassName == VirtualPage::class) {
                    $MetaCanonical
                        ->setReadonly(true)
                        ->setDescription(_t(__CLASS__ . '.LinkOverrideVirtualDesc', 'Linked page will be used.'));
                }
            } else {
                $MetaToggle->push($MetaCanonical = LiteralField::create("CanonicalURL", '<p class="form__field-label">' . _t(__CLASS__ . '.LinkFieldPlaceholder', 'Canonical-URLs needs a Canonical domain in <a href="/admin/settings">SiteConfig</a>') . '</p>'));
            }
            $MetaCanonical->setRightTitle(_t(__CLASS__ . '.LinkFieldRightTitle', 'Used to identify the original resource (URL) to prevent being considered as "duplicate content".'));
        }
    }

    function getorsetCanonicalURL()
    {
        $siteConfig = SiteConfig::current_site_config();
        if (filter_var($siteConfig->CanonicalDomain, FILTER_VALIDATE_URL)) {
            $canonicalBase = trim($siteConfig->CanonicalDomain, '/');

            // dynamic value
            if (method_exists($this->owner, 'CanonicalLink')) {
                $link = $this->owner->CanonicalLink();
            }

            // canonical link on Page
            if (isset($this->owner->CanonicalURL) && $this->owner->CanonicalURL != null) {
                $link = $this->owner->CanonicalURL;
            }

            // use CopyContentFrom()->Link() for VirtualPage
            if ($this->owner->ClassName == VirtualPage::class) {
                $link = $this->owner->CopyContentFrom()->Link();
            }

            // add canonicalBase if relative URL
            if (isset($link)) {
                $urlArray = parse_url($link);
                if (!isset($urlArray['host']) && !isset($urlArray['scheme'])) {
                    $link = $canonicalBase . $link;
                }
            } else {
                // default link with base
                $link = $canonicalBase . $this->owner->Link();
            }

            return $link;
        }
    }

    public function MetaComponents(array &$tags)
    {
        if ($canonLink = $this->getorsetCanonicalURL()) {
            $tags['canonical'] = [
                'tag' => 'link',
                'attributes' => [
                    'rel' => 'canonical',
                    'href' => $canonLink
                ]
            ];
        }
    }
}
