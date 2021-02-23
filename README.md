# An EPub format reader for PHP (modernized!)
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
composer require justinrainbow/epub
```

## Usage

```php
<?php

use Lurn\EPub\Reader;

$epub = Reader::load('book.epub');

printf("Title: %s\n", $epub->metadata->title);
```

## Resources

 * [Epub Format Construction Guide](http://www.hxa.name/articles/content/epub-guide_hxa7241_2007.html)
