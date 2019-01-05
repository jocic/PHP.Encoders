# Encoders

[![Build Status](https://travis-ci.org/jocic/PHP.Encoders.svg?branch=master)](https://travis-ci.org/jocic/PHP.Encoders) [![Coverage Status](https://coveralls.io/repos/github/jocic/PHP.Encoders/badge.svg?branch=master)](https://coveralls.io/github/jocic/PHP.Encoders?branch=master) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/4d076b843bb6460ca56c5428b1e8d14d)](https://www.codacy.com/app/jocic/PHP.Encoders?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=jocic/PHP.Encoders&amp;utm_campaign=Badge_Grade) [![License](https://poser.pugx.org/jocic/encoders/license)](https://packagist.org/packages/jocic/encoders)

Encoders is a creatively named PHP library containing various binary-to-text encoding implementations.

I basically wrote a Base 32 implementation for my other project, Google Authenticator which you can find on GitHub, and thought to myself, hey...why not create an entire library featuring binary-to-text encoders, that's kind of fun? So here it is. A filler project, for fun.

Following specifications are referenced:

*   [RFC 4648](other/specifications/rfc4648.txt) - Base 16, Base 32 & Base 64 Data Encodings

[![Buy Me Coffee](images/buy-me-coffee.png)](https://www.paypal.me/DjordjeJocic)

**Project is still under development...slow ride...take it easy...**

## Versioning Scheme

I use a 3-digit [Semantic Versioning](https://semver.org/spec/v2.0.0.html) identifier, for example 1.0.2. These digits have the following meaning:

*   The first digit (1) specifies the MAJOR version number.
*   The second digit (0) specifies the MINOR version number.
*   The third digit (2) specifies the PATCH version number.

Complete documentation can be found by following the link above.

## Examples

Using encoders from the library is extremely simple but, just in case you are getting started with PHP programming language, I've prepared several examples to help you on your journey. You simply need to instantiate an object of your desired encoder and use the "encode" or "decode" methods respectively.

### Example 1 - Base Encoding & Decoding

```php
$encoder = new Jocic\Encoders\Base\Base32();

echo $encoder->encode("foo");
echo $encoder->decode("MZXW6===");
```

## Installation

There's two ways you can add **Encoders** library to your project:

*   Copying files from the "source" directory to your project and requiring the "Autoload.php" script
*   Via Composer, by executing the command below

```bash
composer require jocic/encoders dev-master
```

## Tests

Following unit tests are available:

*   **Essentials** - Tests for library's essentials ex. Autoloader, etc.
*   **Base** - Tests for Base encoders - Base 16, Base 32 & Base 64.

You can execute them easily from the terminal like in the example below.

```bash
bash ./scripts/phpunit.sh --testsuite essentials
bash ./scripts/phpunit.sh --testsuite base
```

Please don’t forget to install necessary dependencies before attempting to do the God's work above. They may be important.

```bash
bash ./scripts/composer.sh install
```

## Contribution

Please review the following documents if you are planning to contribute to the project:

*   [Contributor Covenant Code of Conduct](code_of_conduct.md)
*   [Contribution Guidelines](contributing.md)
*   [Pull Request Template](pull_request_template.md)
*   [MIT License](license.md)

## Support

Please don't hesitate to contact me if you have any questions, ideas, or concerns.

My Twitter account is: [@jocic_91](https://www.twitter.com/jocic_91)

My support E-Mail address is: [support@djordjejocic.com](mailto:support@djordjejocic.com)

## Copyright & License

Copyright (C) 2018 Đorđe Jocić

Licensed under the MIT license.
