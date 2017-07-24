<?php

use DrupalFinder\DrupalFinder;
use Webmozart\PathUtil\Path;
use Humbug\SelfUpdate\Updater;

set_time_limit(0);

$autoloaders = [
  __DIR__ . '/../../../autoload.php',
  __DIR__ . '/../vendor/autoload.php'
];

foreach ($autoloaders as $file) {
  if (file_exists($file)) {
    $autoloader = $file;
    break;
  }
}

if (isset($autoloader)) {
  require_once $autoloader;
}
else {
  echo 'You must set up the project dependencies using `composer install`' . PHP_EOL;
  exit(1);
}

$DRUSH_SHIM_VERSION = '@git-version@';

$ROOT = FALSE;
$DEBUG = FALSE;
$VAR = FALSE;
$VERSION = FALSE;
$SELF_UPDATE = FALSE;

foreach ($_SERVER['argv'] as $arg) {
  // If a variable to set was indicated on the
  // previous iteration, then set the value of
  // the named variable (e.g. "ROOT") to "$arg".
  if ($VAR) {
    $$VAR = "$arg";
    $VAR = FALSE;
  }
  else {
    switch ($arg) {
      case "-r":
        $VAR = "ROOT";
        break;
      case "--debug":
        $DEBUG = TRUE;
        break;
      case "--version":
        $VERSION = TRUE;
        break;
      case "self-update":
        $SELF_UPDATE = TRUE;
        break;
    }
    if (substr($arg, 0, 7) == "--root=") {
      $ROOT = substr($arg, 7);
    }
  }
}

if ($ROOT === FALSE) {
  $ROOT = getcwd();
}
else {
  $ROOT = Path::canonicalize($ROOT);
}

$drupalFinder = new DrupalFinder();

if ($VERSION || $DEBUG || $SELF_UPDATE) {
  echo "Drush Shim Version: {$DRUSH_SHIM_VERSION}" .  PHP_EOL;
}

if ($SELF_UPDATE) {
  if ($DRUSH_SHIM_VERSION === '@' . 'git-version' . '@') {
    echo "Automatic update not supported.\n";
    exit(1);
  }
  $updater = new Updater(null, false);
  $updater->setStrategy(Updater::STRATEGY_GITHUB);
  $updater->getStrategy()->setPackageName('webflo/drush-shim');
  $updater->getStrategy()->setPharName('drush.phar');
  $updater->getStrategy()->setCurrentLocalVersion($DRUSH_SHIM_VERSION);
  try {
    $result = $updater->update();
    echo $result ? "Updated!\n" : "No update needed!\n";
    exit(0);
  } catch (\Exception $e) {
    echo "Automatic update failed, please download the latest version from https://github.com/webflo/drush-shim/releases\n";
    exit(1);
  }
}

if ($DEBUG) {
  echo "ROOT: " . $ROOT . PHP_EOL;
}

if (!$drupalFinder->locateRoot($ROOT)) {
  echo 'The Drush launcher could not find a Drupal site to operate on. Please do *one* of the following:' . PHP_EOL;
  echo '  - Navigate to any where within yur Drupal project and try again.' . PHP_EOL;
  echo '  - Add --root=/path/to/drush so Drush knows where your site is located.' . PHP_EOL;
  echo '  - Add a site alias o Drush knows where your site is located.' . PHP_EOL;
  exit(1);
}

$drupalRoot = $drupalFinder->getDrupalRoot();

if ($DEBUG) {
  echo "DRUPAL ROOT: " . $drupalRoot . PHP_EOL;
  echo "COMPOSER ROOT: " . $drupalFinder->getComposerRoot() . PHP_EOL;
  echo "VENDOR ROOT: " . $drupalFinder->getVendorDir() . PHP_EOL;
}

chdir($drupalRoot);

require_once $drupalRoot . '/autoload.php';

$methods = [
  'local' => [
    $drupalRoot . '/../vendor/drush/drush/includes/preflight.inc',
    $drupalRoot . '/../vendor/drush/drush/includes/context.inc'
  ],
  'phar' => [
    'phar://' .  __DIR__ . '/../phar/drush.phar/includes/preflight.inc',
    'phar://' .  __DIR__ . '/../phar/drush.phar/includes/context.inc',
  ]
];

$bootstrapped = FALSE;

foreach ($methods as $files) {
  foreach ($files as $file) {
    if (file_exists($file)) {
      require_once $file;
      $bootstrapped = TRUE;
    }
  }
  if ($bootstrapped) {
    break;
  }
}

drush_set_option('root', $drupalRoot);
drush_set_option('local', TRUE);
exit(drush_main());
