# Drush Launcher

A small wrapper around Drush for your global $PATH.

## Why?

In order to avoid dependency issues, it is best to require Drush on a per-project basis via Composer (`composer require drush/drush`). This makes Drush available to your project by placing it at `vendor/bin/drush`.

However, it is inconvenient to type `vendor/bin/drush` in order to execute Drush commands.  By installing the drush launcher globally on your local machine, you can simply type `drush` on the command line, and the launcher will find and execute the project specific version of drush located in your project's `vendor` directory.

## Installation

1. Download latest stable release via CLI (code below) or browse to https://github.com/drush-ops/drush-launcher/releases/latest.

    OSX:
    ```Shell
    curl -OL https://github.com/drush-ops/drush-launcher/releases/download/0.3.1/drush.phar
    ```

    Linux:

    ```Shell
    wget -O drush.phar https://github.com/drush-ops/drush-launcher/releases/download/0.3.1/drush.phar
    ```
1. Make downloaded file executable: `chmod +x drush.phar`
1. Move drush.phar to a location listed in your `$PATH`, rename to `drush`: 

    ```Shell
    sudo mv drush.phar /usr/local/bin/drush
    ```
    
## Update

The Drush Launcher is able to self update to the latest release. 

```Shell
    drush self-update
```

## License

GPL-2.0+
