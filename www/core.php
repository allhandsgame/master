<?php
/**
 * Core constants and functions.
 *
 * Application and test need to share some constants to run properly. This
 * configuration file allows to have them shared.
 *
 * @author michael@xethorn.net (Michael Ortali)
 */

/**
 * @type {boolean}
 * @const
 */
const DEBUG = true;

/**
 * @type {string}
 * @const
 */
const ERROR404 = 'error-404';


/**
 * Quick import function.
 *
 * Provide an easy way to import file from this project.
 *
 * @param {string} $filename The filename to import. Extension should not be
 *   included.
 */
function import($filename) {
  if (!preg_match('#^[a-z_\/]+$#i', $filename)) {
    throw new Exception("The filename ".$filename." is not conform.");
  }

  $filename = dirname(__FILE__).'/'.strtolower($filename).'.php';
  if (!file_exists($filename)) {
    throw new Exception("The filename is incorrect. Are you sure this file
        exists?");
  }

  require_once $filename;
}
?>