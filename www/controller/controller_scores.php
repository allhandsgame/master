<?php
import('controller/controller_base');
import('model/game');

/**
 * Scores.
 *
 * Shows the current scores per user and the number of rounds.
 *
 * @author michael@xethorn.net (Michael Ortali)
 */

class ControllerScores extends ControllerBase {
  /** @override */
  public $templateName = '/score';

  /** @override */
  public static $_sessionRequired = true;

  /** @override */
  public function initialize() {
    $this->_display['game'] = Game::load();
  }
}
?>