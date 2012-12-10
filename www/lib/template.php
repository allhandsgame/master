<?php
/**
 * Template management system.
 *
 * This library manages the templates. It's a very lightweight library, it
 * doesn't do much except adding a layer between the front-end and the
 * controllers.
 *
 * @author michael@xethorn.net (Michael Ortali)
 */

class Template {
  /**
   * Template filename.
   * @type {string}
   */
  public $filename;

  /**
   * Display dictionary.
   * @type {StdClass}
   * @private
   */
  private $_display;

  /**
   * Instantiate the template object.
   *
   * @constructor
   */
  public function __construct() {
    $this->_display = new StdClass;
  }

  /**
   * Define the view.
   *
   * Do a set of checks to make sure the filename is not empty and then exists.
   * If one of those two conditions isn't met, bubbling exceptions.
   *
   * @param {string} $filename The name of the file.
   */
  public function setView($filename) {
    if(empty($filename)) {
      throw new Exception('The view name cannot be empty');
    }

    $filename = dirname(dirname(__FILE__)).'/view'.$filename.'.php';
    if(!file_exists($filename)) {
      throw new Exception('Cannot find the view: '.$filename.'.');
    }

    $this->filename = $filename;
  }

  /**
   * Define the variables of the display dictionary.
   *
   * @param {array} $variables The array of variables to add to the display
   *   dictionary.
   */
  public function setVariables(array $variables) {
    if(!is_array($variables)) {
      throw new Exception('You are trying to setup variables from a non Array.');
    }

    foreach($variables as $key => $valeur) {
      $this->_display->{$key} = $valeur;
    }
  }

  /**
   * Get the content of the page.
   *
   * @return {string}
   */
  public function getContent() {
    ob_start();
      $t = $this->_display;
      include($this->filename);
      $content = ob_get_contents();
    ob_end_clean();
    return $content;
  }

  /**
   * A shortcut to create fast views.
   *
   * @param {string} $filename The name of the template to use.
   * @param {array} $variables The variables to add to the dictionary.
   * @param {boolean} $returnObject if we're returning the Template object or
   *    the value.
   * @return {string|Template} Final state of the view.
   */
  public static function render($filename, array $variables = array(),
      $returnObject=false) {
    $templates = new Template();
    $templates->setView($filename);
    $templates->setVariables($variables);

    if(!$returnObject) {
      return $templates->getContent();
    }

    return $templates;
  }
}

/**
 * For the templates, a little shortcut function to display a
 * text.
 */
function •($text) {
  echo htmlentities($text, ENT_QUOTES, 'UTF-8');
}
?>