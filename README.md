# instagram-php
Instagram API for PHP using Guzzle

## Installation
Create a directory with name .cred in your code directory, auth token will be placed in .cred directory
For example
```
instagram (root)
  |
   ---- conf
   ---- reference
   ---- vendor
   ---- .cred
```

## Usage
Include instagram.php file in your code and provide the authentication url in constructor, for example authentication url is auth.php

```php
include_once('instagram.php');
$instagram = new Instagram('auth.php');
```
Make call to instagram using their endpoints
For example to get posts liked by me

```php
try {
	$response = $instagram->get('users/self/media/liked');
} catch (Exception $e) {
	echo $e->getMessage();
}
```

index.php contains the example code

## Authentication Scope

Right now authentication scope is set to public_content in auth.php, you can change it if needed.
