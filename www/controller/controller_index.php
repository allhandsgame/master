<?php
import('controller/controller_base');

/**
 * Homepage of the game.
 *
 * Invites the user to start a game. It randomly selects a number and initiate
 * the sequence. It creates an arbitrary game number that can be shared with
 * others.
 *
 * @author michael@xethorn.net (Michael Ortali)
 */

class ControllerIndex extends ControllerBase {
  /** @override */
  protected $templateName = '/homepage';
}
?>