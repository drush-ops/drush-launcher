<?php

use DrupalFinder\DrupalFinder;

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

$drupalFinder = new DrupalFinder();

if (!$drupalFinder->locateRoot(getcwd())) {
  echo 'Could not find Drupal in the current path.' . PHP_EOL;
  exit(1);
}

$drupalRoot = $drupalFinder->getDrupalRoot();
chdir($drupalRoot);

require_once $drupalRoot . '/autoload.php';

$files = [
  $drupalRoot . '/../vendor/drush/drush/includes/preflight.inc',
  $drupalRoot . '/../vendor/drush/drush/includes/context.inc'
];

foreach ($files as $file) {
  if (file_exists($file)) {
    require_once $file;
  }
  else {
    echo 'The Drupal site has not local drush.' . PHP_EOL;
    exit(1);
  }
}

drush_set_option('root', $drupalRoot);
drush_set_option('local', TRUE);
exit(drush_main());
