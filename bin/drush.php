<?php

use DrupalFinder\DrupalFinder;
use Webmozart\PathUtil\Path;

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

$ROOT = FALSE;
$DEBUG = FALSE;
$VAR = FALSE;

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

if ($DEBUG) {
  echo "ROOT: " . $ROOT . PHP_EOL;
}

if (!$drupalFinder->locateRoot($ROOT)) {
  echo 'Could not find Drupal in the current path.' . PHP_EOL;
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
