# Listing Page content block for Silverstrope CMS

An elemental element that outputs the listing content of the Listing Page it's added to.

## Install

```sh
composer require "symbiote/silverstripe-elemental-listingpagelisting:dev-ss6"
```

> For this fork, ensure a repository is added to your project's composer.json:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/nswdpc/silverstripe-elemental-listingpagelisting.git"
    }
]
```

## Configuration

1. Install
1. Add the following configuration to your project (some blocks might already be set, if so add the entry):

```yml
---
Name: 'app-elemental'
---
Page:
  allowed_elements:
    - 'Symbiote\ListingPageElement\Model\ElementListingPageListing'
```
