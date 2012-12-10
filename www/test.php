<?php
/**
 * Testing environment.
 *
 * Only works in debug mode.
 *
 * @author michael@xethorn.net (Michael Ortali)
 */

require_once('core.php');

if (DEBUG) {
  import('lib/simpletest/autorun');
  import('lib/_test');
  import('model/_test');
}
?>