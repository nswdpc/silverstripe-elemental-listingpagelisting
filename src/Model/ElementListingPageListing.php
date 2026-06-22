<?php

namespace Symbiote\ListingPageElement\Model;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Controller;
use Symbiote\ListingPage\ListingPage;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Core\Validation\ValidationResult;

class ElementListingPageListing extends BaseElement
{
    private static string $table_name = 'ElementListingPageListing';

    private static string $singular_name = 'listing block';

    private static string $plural_name = 'listing blocks';

    private static string $class_description = 'Listing for a Listing Page';

    private static string $icon = 'font-icon-list';

    #[\Override]
    public function getCMSFields()
    {
        return parent::getCMSFields();
    }

    /**
     * @return string
     */
    #[\Override]
    public function getType()
    {
        return _t(self::class . '.BlockType', 'Listing Page listing');
    }

    /**
     * @return string
     */
    #[\Override]
    public function getSummary()
    {
        return '';
    }

    /**
     * Generate the listing content.
     * {@link ListingPage->Content()} assumes the placeholder is in the $Content field,
     * so we need to temporarily replace the $Content value with the placeholder.
     */
    public function getListing(): ?DBHTMLText
    {
        $page = $this->getPage();
        if (!$page || !($page instanceof \Symbiote\ListingPage\ListingPage)) {
            return null;
        }

        $oldContent = $page->Content;
        $page->Content = '$Listing';
        $content = DBField::create_field(DBHTMLText::class, $page->Content());
        $page->Content = $oldContent;

        return $content instanceof DBHTMLText ? $content : null;
    }

    #[\Override]
    public function validate(): ValidationResult
    {
        $result = parent::validate();
        $page = $this->getPage();

        if (!($page instanceof \Symbiote\ListingPage\ListingPage)) {
            $result->addError('This block can only be added to a Listing Page');
        }

        return $result;
    }

    #[\Override]
    public function canCreate($member = null, $context = [])
    {
        if (!($controller = Controller::curr())
            || !$controller->hasMethod('currentPageID')
            || !($id = $controller->currentPageID())
            || !($page = SiteTree::get_by_id($id))
            || !($page instanceof \Symbiote\ListingPage\ListingPage)
        ) {
            return false;
        }

        return parent::canCreate($member, $context);
    }
}
