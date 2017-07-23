# Drush Shim

A small wrapper around Drush for your global $PATH.

## Why?

A site local Drush is the easiest solution to avoid dependency issues and your project will contain all necessary tools for development, but it is still good DX to type ``drush`` instead of ``../bin/drush``.

## Installation

```
# Download latest stable release using the code below or browse to https://github.com/webflo/drush-shim/releases/latest.
wget https://github.com/webflo/drush-shim/releases/download/0.2.2/drush.phar

# Rename to `drush` instead of `php drush.phar`. Destination can be anywhere on $PATH. 
chmod +x drush.phar
sudo mv drush.phar /usr/local/bin/drush
```

## License

GPL-2.0+
