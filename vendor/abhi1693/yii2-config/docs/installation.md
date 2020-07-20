Installation
============

This document will guide you through the process of installing Yii2-Config using **composer**. Installation is a quick and
easy three-step process.

> **NOTE:** Before we start make sure that you have properly configured **db** application component.


Step 1: Download using composer
-------------------------------

Add Yii2-config to the require section of your **composer.json** file:

```
{
    "require": {
        "abhi1693/yii2-config": "*"
    }
}
```

And run following command to download extension using **composer**:

```bash
$ php composer.phar update
```

Step 2: Configure your application
----------------------------------

```php
$config = [
    ...
    'components' => [
        ...
        'config' => [
            'class'         => 'abhimanyu\config\components\Config', // Class (Required)
            'db'            => 'db',                                 // Database Connection ID (Optional)
            'tableName'     => '{{%config}}',                        // Table Name (Optioanl)
            'cacheId'       => 'cache',                              // Cache Id. Defaults to NULL (Optional)
            'cacheKey'      => 'config.cache',                       // Key identifying the cache value (Required only if cacheId is set)
            'cacheDuration' => 100                                   // Cache Expiration time in seconds. 0 means never expire. Defaults to 0 (Optional)
        ]
    ]
]
```

Step 3: Updating database schema
--------------------------------

```
yii migrate/up --migrationPath=@vendor/abhi1693/yii2-config/migrations
```
