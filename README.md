# About
This library simplifies work with emails in PHP. The main class – RawEmail.php offers building a raw email. The raw email
supports:
- Attachments
- Multiple recipients
- Both HTML and Plain text versions

## Install via composer

```bash
composer require hyperdigital/raw-email
```

## Use

```php
<?php

use Hyperdigital\RawEmail\RawEmail;

$html = "<h1>HTML version</h1>";
$rawEmail = new RawEmail("no-reply@hyperdigital.de", "no-reply@hyperdigital.de");
$rawData = $rawEmail->build(array('developer@hyperdigital.de'), 'Some subject', 'Plain text version', $html);

// Send the email data
```

## Use with Amazon SES (example using ^2.8)

- Install aws/aws-sdk-php via composer

```bash
composer require aws/aws-sdk-php ^2.8
```

```php
<?php

use Aws\Common\Aws;
use Hyperdigital\RawEmail\RawEmail;

$html = "<h1>HTML version</h1>";
$rawEmail = new RawEmail("no-reply@hyperdigital.de", "no-reply@hyperdigital.de");
$rawData = $rawEmail->build(array('developer@hyperdigital.de'), 'Some subject', 'Plain text version', $html);

$aws = Aws::factory($credentials);
$ses = $aws->get('Ses');

$ses->sendRawEmail(array(
    'RawMessage' => array(
        'Data' => base64_encode($rawData),
        ),
    )
);

```

## Advanced

If you need some additional functionality, feel free to inspect how RawEmail.php class works and use the component
classes to create your customized emails.
