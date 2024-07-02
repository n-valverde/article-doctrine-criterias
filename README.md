## This app is a simple Symfony webapp to showcase the usage of Doctrine Criterias with Lazy Collections
## [You can find the related article here on my Medium](https://medium.com/the-sensiolabs-tech-blog/doctrine-criterias-and-lazy-collections-magic-ae57cd275afb)

# Requirements

* PHP 8.2 or above
* composer

# Installation

* Clone the repository
* Run `composer install`
* Run `bin/console doctrine:database:create && bin/console doctrine:migration:migrate -n && bin/console doctrine:fixtures:load -n`
* Run `symfony serve` or `php -S 127.0.0.1:80 public/index.php` (update the port if required)
* Open the app in your browser

# Note about requirements

The requirements of this app come from Symfony,
but the features showcased here are about Doctrine ORM.
While some signatures differ, all concepts showcased apply to both ORM V2 and V3.
