<?php
namespace DorsetDigital\SilverStripeCanonical;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\FieldList;


class ConfigCanonicalExtension extends DataExtension
{
    private static $db = [
        'CanonicalDomain' => 'Varchar(255)'
    ];
    
    public function updateCMSFields(FieldList $fields) {        
        $fields->addFieldToTab('Root.Canonical', LiteralField::create('Info', '<p>The canonical domain will be added to the HTML head of your pages.  It should be specified with the full protocol and with no trailing slash, eg.  https://www.example.com</p>'));
        $fields->addFieldToTab('Root.Canonical', TextField::create('CanonicalDomain')->setDescription('eg. https://www.example.com'));
        return $fields;        
    }
}
