# Drush Launcher

A small wrapper around Drush for your global $PATH.

## Why?

In order to avoid dependency issues, it is best to require Drush on a per-project basis via Composer (`composer require drush/drush`). This makes Drush available to your project by placing it at `vendor/bin/drush`.

However, it is inconvenient to type `vendor/bin/drush` in order to execute Drush commands.  By installing the drush launcher globally on your local machine, you can simply type `drush` on the command line, and the launcher will find and execute the project specific version of drush located in your project's `vendor` directory.

## Installation - Phar

1. Download latest stable release via CLI (code below) or browse to https://github.com/drush-ops/drush-launcher/releases/latest.

    OSX:
    ```Shell
    curl -OL https://github.com/drush-ops/drush-launcher/releases/latest/download/drush.phar
    ```

    Linux:

    ```Shell
    wget -O drush.phar https://github.com/drush-ops/drush-launcher/releases/latest/download/drush.phar
    ```
1. Make downloaded file executable: `chmod +x drush.phar`
1. Move drush.phar to a location listed in your `$PATH`, rename to `drush`: 

    ```Shell
    sudo mv drush.phar /usr/local/bin/drush
    ```
    
1. Windows users: create a drush.bat file in the same folder as drush.phar with the following lines. This gets around the problem where Windows does not know that .phar files are associated with `php`:
   
    ``` Bat
    @echo off
    php "%~dp0\drush.phar" %*
    ```

## Update

The Drush Launcher Phar is able to self update to the latest release.

```Shell
    drush self-update
```

## Alternatives

If you only have one codebase on your system (typical with VMs, Docker, etc,), you should add `/path/to/vendor/bin` to your `$PATH`. Drush 10 is smart enough to find the `PROJECT_ROOT` and `DRUPAL_ROOT` when it is run from the bin directory.

## Fallback

When a site-local Drush is not found, this launcher usually throws a helpful error.
You may avoid the error and instead hand off execution to a global Drush (any version)
by exporting an environment variable.

`export DRUSH_LAUNCHER_FALLBACK=/path/to/drush`

## Xdebug compatibility

Drush Launcher, like Composer automatically disables Xdebug by default. This improves performance substantially. You may override this feature by setting an environment variable. ``DRUSH_ALLOW_XDEBUG=1 drush [command]``

## License

GPL-2.0+
