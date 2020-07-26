# PayWithBank3D PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/parkwayprojects/paywithbank3d-php.svg?style=flat-square)](https://packagist.org/packages/parkwayprojects/paywithbank3d-php)
[![Build Status](https://img.shields.io/travis/parkwayprojects/paywithbank3d-php/master.svg?style=flat-square)](https://travis-ci.org/parkwayprojects/paywithbank3d-php)
[![Quality Score](https://img.shields.io/scrutinizer/g/parkwayprojects/paywithbank3d-php.svg?style=flat-square)](https://scrutinizer-ci.com/g/parkwayprojects/paywithbank3d-php)
[![Total Downloads](https://img.shields.io/packagist/dt/parkwayprojects/paywithbank3d-php.svg?style=flat-square)](https://packagist.org/packages/parkwayprojects/paywithbank3d-php)

PayWithBank3D PHP is a library for using the PayWithBank3D API from PHP.

## Installation

You can install the package via composer:

```bash
composer require parkwayprojects/paywithbank3d-php
```

## Usage
First you initialize the library with your  public key, secret key and option(live or staging)

``` php
$bank3d = \ParkwayProjects\PayWithBank3D\PayWithBank3D::setup('test@payzone', 'PayzoneAPP', 'staging');
```

## Transaction
initialize a transaction

```php
\ParkwayProjects\PayWithBank3D\Transaction::addBody('reference', time())
            ->addBody('amount', '100000')
            ->addBody('currencyCode', 'NGN')
            ->addBody('customer', [
                'name' => 'Edward Paul',
                'email' => 'infinitypaul@live.com',
                'phone' => '0848494839'
            ])
            ->addBody('returnUrl', route('verify'))
            ->addBody('color', '#FF0000')
            ->addBody('metadata', [
                'orderId'=> '1234'
            ])->getAuthorizationUrl()->redirectNow();
```
This will automatically take you to secure payment page on PayWithBank3D, Once payment is completed, you are redirected to the url you specify in the returnURL

## Verify Transaction

```php
\ParkwayProjects\PayWithBank3D\Transaction::verify();
```
This return the status of the payment you just made and some other values of the transaction

## Configuration Parameters

| Parameter   |      Required      |  Description |
|----------|:-------------:|------:|
| amount |  True | Amount to be charged in kobo. |
| color |    False   |   You get to choose a theme color for the payment modal that reflects your brand |
| customer | True |    This is an object that contains customer details |
| email | False |    Customer email address |
| metadata | False |    This is an object that allows you to add additional detail(s) to your request |
| phone | False |    Phone number of customer |
| reference | False |    Your unique transaction reference. |

### Testing

``` bash
composer test
```



## Credits

- [Paul Edward](https://github.com/infinitypaul)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


