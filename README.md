
# Technology Stack

* PHP 7.1
* MySQL 5.7 / PerconaDB 5.7
* Memcached
* Slim Framework v3

# Create a Project with this template

Run:
```
composer create project meezaan/microservice-template project-name
```

Now Run the doctrine generate entities and create schema commands shown below. Point an Apache / nginx at the www/index.php file, and you have a running microservice. Tweak stuff in src/ to your heart's content to build a new microservice.

See composer.json to add / remove packages as you need them.

## Doctrine
Generate Entities (getters and setters) ``` vendor/bin/doctrine orm:generate-entities src/```

Generate Proxies ``` vendor/bin/doctrine orm:generate-proxies ```

Update ``` vendor/bin/doctrine orm:schema-tool:update```

Create ``` vendor/bin/doctrine orm:schema-tool:create```

## Behat
```
vendor/bin/behat -dl
```

## PHPUnit
```
vendor/bin/phpunit
```

## PHP Mess Detector
Run the following to see your options and run a report
```
vendor/bin/phpmd src/
```

## PHP Code Sinffer
To see issues:
```
vendor/bin/phpcs src/
```

To autofix per PSR-2:
```
vendor/bin/phpcbf src/
```

## Generate PHP docs
```
vendor/bin/apigen generate src/ --destination docs/php
```

## ApiDocJS API Documentation
This requires ```npm```. To install:

```
npm install apidoc -g
```

To run:
```
apidoc -i routes/ -o docs/api/
```



# To Do

```
Feature Toggling / flagging
Add API Docs
Add PHP Docs
```
