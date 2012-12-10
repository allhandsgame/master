<?php
import('controller/controller_base');
import('model/game');

/**
 * Result.
 *
 * Display which user won the round and invite to start a new round.
 *
 * @author michael@xethorn.net (Michael Ortali)
 */

class ControllerResult extends ControllerBase {
  /** @override */
  public static $_sessionRequired = true;

  /** @override */
  public $templateName = '/result';

  /** @override */
  public function initialize() {
    $game = Game::load();
    try {
      $this->_display['game'] = $game;
      $this->_display['gameWinner'] = $game->findWinner();
      $game->save(true);
    } catch(Exception $e) {
      $this->templateName = '/noresults';
    }
  }
}
?>