<?php

use DrupalFinder\DrupalFinder;

set_time_limit(0);

require_once __DIR__ . '/../vendor/autoload.php';

$drupalFinder = new DrupalFinder();
$drupalRoot = $drupalFinder->locateRoot(getcwd());

if (!$drupalRoot) {
  echo PHP_EOL . 'Could not find Drupal root' . PHP_EOL;
  exit(1);
}

chdir($drupalRoot);

require_once $drupalRoot . '/autoload.php';
require_once $drupalRoot . '/../vendor/drush/drush/includes/preflight.inc';
require_once $drupalRoot . '/../vendor/drush/drush/includes/context.inc';

drush_set_option('root', $drupalRoot);
drush_set_option('local', TRUE);
exit(drush_main());
