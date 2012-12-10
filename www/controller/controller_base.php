<?php
/**
 * Base controller.
 *
 * Provide the basic methods and methods that can be overridden independently.
 * It also brings a basic structure on what each view should have.
 *
 * @author michael@xethorn.net (Michael Ortali)
 */

abstract class ControllerBase {
  /**
   * The display variables for our the views.
   * @type {Object}
   * @private
   */
  protected $_display;

  /**
   * Template name.
   * @type {string}
   * @protected
   */
  protected $templateName;

  /**
   * Page name.
   * @type {string}
   * @protected
   */
  public $pageName = 'All Hands Game';

  /**
   * Page description.
   * @type {string}
   * @protected.
   */
  public $pageDescription = 'The best game you\'ve ever played online';

  /**
   * Flag indicating if the session is required or not.
   *
   * If the session is required and the user doesn't have one yet, the user will
   * most likely be redirected to the homepage to instantiate a new game.
   *
   * @type {boolean}
   * @public
   */
  public static $_sessionRequired;

  /**
   * The constructor instantiate the different calls.
   * @constructor.
   */
  public function __construct() {
    $this->_display = array();
    $currentClass = get_class($this);
    $currentClassVars = get_class_vars($currentClass);
    if ($currentClassVars['_sessionRequired'] and empty($_SESSION['game'])) {
      RequestHandler::redirect('/');
    }

    $this->initialize();
  }

  /**
   * Method that can be overridden if the controller wants to do some extra
   * checks prior calling the method to display the view.
   */
  protected function initialize() {}

  /**
   * Get the view.
   */
  public function getView() {
    return Template::render($this->templateName, $this->_display);
  }
}
?>