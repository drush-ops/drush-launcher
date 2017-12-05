# Drush Launcher

A small wrapper around Drush for your global $PATH.

## Why?

In order to avoid dependency issues, it is best to require Drush on a per-project basis via Composer (`composer require drush/drush`). This makes Drush available to your project by placing it at `vendor/bin/drush`.

However, it is inconvenient to type `vendor/bin/drush` in order to execute Drush commands.  By installing the drush launcher globally on your local machine, you can simply type `drush` on the command line, and the launcher will find and execute the project specific version of drush located in your project's `vendor` directory.

## Installation

1. Download latest stable release via CLI (code below) or browse to https://github.com/drush-ops/drush-launcher/releases/latest.

    OSX:
    ```Shell
    curl -OL https://github.com/drush-ops/drush-launcher/releases/download/0.4.2/drush.phar
    ```

    Linux:

    ```Shell
    wget -O drush.phar https://github.com/drush-ops/drush-launcher/releases/download/0.4.2/drush.phar
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

## Fallback

When a site-local Drush is not found, this launcher usually throws a helpful error.
You may avoid the error and instead hand off execution to a global Drush (any version)
by doing *either* of:

1. Specify an environment variable: `DRUSH_LAUNCHER_FALLBACK=/path/to/drush`
1. Specify an option: `--fallback=/path/to/drush`

## License

GPL-2.0+
