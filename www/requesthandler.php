<?php
require_once('core.php');
import('lib/template');

/**
 * Dispatcher.
 *
 * The request is hitting first the dispatcher that will find the appropriate
 * controller and will request the controller to return the information.
 *
 * @author michael@xethorn.net (Michael Ortali)
 */

class RequestHandler {
  /**
   * @type {RequestHandler}
   */
  private static $_instance = null;

  /**
   * @type {ControllerBase}
   */
  private static $_currentController;

  /**
   * Create the singleton of the RequestHandler.
   *
   * @return {RequestHandler}
   */
  public static function getInstance() {
    if(RequestHandler::$_instance == null) {
      RequestHandler::$_instance = new RequestHandler();
    }
    return RequestHandler::$_instance;
  }

  /**
   * Treat the request.
   *
   * Values are initialized, simple control checks are made (environment basic
   * security), then we're assigning all the different values.
   *
   * @return void
   */
  public function __construct() {
    $this->initialize();
    $this->requestController();
    echo $this->getView();
  }

  /**
   * Instantiate the environment.
   */
  private function initialize() {
    error_reporting(DEBUG ? E_ALL : 0);
    session_start();

    // Check if the magic quotes are turned off. If not
    // we're displaying an error.
    if (true === (boolean) get_magic_quotes_gpc()) {
      throw new Exception("The application works only if Magic Quotes are turned off.");
    }
    return;
  }

  /**
   * Request the controller.
   *
   * Based on the parameters provided in the request (more precisely the
   * 'controller' parameter), the RequestHandler will call this controller.
   */
  private function requestController() {
    if (!empty($_GET) && !empty($_GET['controller'])) {
      if ($_GET['controller'] == 'error404') {
        RequestHandler::get404();
        exit();
      } else if (!preg_match('#^[a-z]+$#i', $_GET['controller'])) {
        throw new Exception("The controller name is not normalized.");
      }

      $controllerName = trim($_GET['controller']);
      import('controller/controller_'.$controllerName);
      $controllerName = 'Controller'.ucfirst($controllerName);
      RequestHandler::$_currentController = new $controllerName();
    }
  }

  /**
   * Get all information from the view.
   *
   * @return {string}
   */
  public function getView() {
    import('lib/template');
    import('model/game');

    if (empty(RequestHandler::$_currentController)) {
      throw new Exception('The current controller cannot be empty.');
    }

    $controller = RequestHandler::$_currentController;
    return Template::render(
      '/index',
      array(
        'title' => $controller->pageName,
        'description' => $controller->pageDescription,
        'view' => $controller->getView(),
        'game' => Game::load()
      )
    );
  }

  /**
   * Set a 404 error page.
   *
   * @return {string}
   */
  public static function get404() {
    echo Template::render(
      '/index',
      array(
        'title' => 'Error 404',
        'description' => 'This page has no content.',
        'view' => 'Ooops, the page you\'re looking for cannot be found',
      )
    );
  }

  /**
   * Redirect the user to a certain page.
   */
  public static function redirect($url) {
    header('location:'.$url);
    exit();
  }
}


/**
 * Process the request.
 */

try {
  $main = RequestHandler::getInstance();
}
catch(Exception $e) {
  if (false === DEBUG) {
    if($e->getMessage() == ERROR404) {
      echo RequestHandler::get404();
    } else {
      echo "Something went wrong";
    }
  }
  else {
    if($e->getMessage() == ERROR404) {
      echo RequestHandler::get404();
    }
    else {
      echo
        $e->getMessage()."\n".
        $e->getTraceAsString()."\n";
      echo "POST:";
      var_dump($_POST);
      echo "GET:";
      var_dump($_GET);
    }
  }
}
?>
