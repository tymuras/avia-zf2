# Sample Task Modulefor Zend Framework 2

## Introduction

Task is a sample Module based on the <a href="http://framework.zend.com/manual/2.0/en/user-guide/overview.html">(Getting Started)</a> guide framework.zend.com .

## Installation

### Main Setup

1. Clone this project into your `./module/` directory and enable it in your
   `application.config.php` file.

```php
return array(
    'modules' => array(
        'Application',
        'Task',//add this to your configuration
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
```

Copy the These files

 * `module/Task/config/database.local.php.dist` to `config/autload/database.local.php`
 * `module/Task/config/global.php.dist` to `config/autload/global.php`

###Database Setup
Import module/Task/data/task.sql into your database

###Usage
Browser to the task page

`your-domain-name/task`