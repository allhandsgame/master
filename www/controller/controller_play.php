<?php
import('controller/controller_base');
import('model/game');

/**
 * Play page.
 *
 * Invite the players to select their hands.
 *
 * @author michael@xethorn.net (Michael Ortali)
 */

class ControllerPlay extends ControllerBase {
  /** @override */
  public static $_sessionRequired = true;

  /** @override */
  public $templateName = '/play';

  /** @override */
  public function initialize() {
    $game = Game::load();

    $currentPlayer = (!empty($_POST['currentPlayer'])) ? (int) $_POST['currentPlayer'] : 0;

    if (!empty($_POST['hand'])) {
      $game->setHandForPlayer($currentPlayer, $_POST['hand']);
      $currentPlayer++;
      $game->save(false);
    }

    if ($currentPlayer == 2) {
      RequestHandler::redirect('/result');
    }

    $this->_display['game'] = $game;
    $this->_display['currentPlayer'] = $currentPlayer;
  }
}
?>