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

        $CanonicalDomainField = TextField::create('CanonicalDomain')
            ->setDescription(_t(__CLASS__ . '.InfoField', 'The canonical domain will be added to the HTML head of your pages.'))
            ->setAttribute('placeholder', _t(__CLASS__ . '.CanonicalDomainDescription', 'https://www.example.com'));

        $fields->addFieldToTab('Root.Canonical', $CanonicalDomainField);

        return $fields;
    }
}
