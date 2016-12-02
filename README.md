# Drush Shim

A small wrapper around Drush for your global $PATH.

## Why?

A site local Drush is the easiest solution to avoid dependency issues and your project will contain all necessary tools for development, but it is still good DX to type ``drush`` instead of ``../bin/drush``.

## Installation

```
composer global remove drush/drush
composer global require webflo/drush-shim
```
