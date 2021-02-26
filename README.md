# An EPub format reader for PHP (modernized!)
This package is based on [justinrainbow/epub](https://github.com/justinrainbow/epub), with several changes since the original hadn't been updated in over 8 years. In particular, one of the upgrades is the ability to extract the HTML content of an epub file, rather than just metadata. It has also received improvements in developer experience. This is being used primarily for an internal project, so support and maintenance of the package will only go as far as the extent of our internal needs (but it does provide a more modern starting point for anyone wishing to fork).

## Installation
Add a VCS repository to your composer.json file:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/lurnforks/epub"
        }
    ]
}
```

Then require the original package via composer:

```bash
composer require justinrainbow/epub:^0.2.0
```

## Usage

```php
<?php

namespace Lurn\EPub\Reader;

$epub = Reader::make('book.epub');

printf("Title: %s\n", $epub->metadata->title);
```

## Testing
To run the test suite, ensure you've installed the project's dependencies with `composer install` and then run:

```bash
composer test
```

You can pass options to phpunit (for example, for filtering):

```bash
composer test -- --filter=ReaderTest
```

## Resources

 * [Epub Format Construction Guide](http://www.hxa.name/articles/content/epub-guide_hxa7241_2007.html)
