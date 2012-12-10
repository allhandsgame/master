<?php
import('model/hand');

/**
 * Game.
 *
 * The game object store the type of player and their respective store. All
 * those information are stored in the temporary session since no records of the
 * game are being saved (session is over, the game is destroyed).
 *
 * @author michael@xethorn.net (Michael Ortali)
 */
class Game {
  /**
   * @type {Array.<number, GamePlayer>}
   */
  public $players;

  /**
   * Current player id.
   * @type {number}
   * @private
   */
  private $_currentPlayer = 0;

  /**
   * @type {number}
   */
  public $roundCount = 1;


  /**
   * Initialize the game for the first time.
   *
   * @param {string} $player1Type Type of the first player.
   * @param {string} $player2Type Type of the second player.
   */
  public function initialize($player1Type, $player2Type) {
    $this->players = Array(new GamePlayer(), new GamePlayer());
    $this->players[0]->setType($player1Type);
    $this->players[1]->setType($player2Type);
  }


  /**
   * Find the winner.
   */
  public function findWinner() {
    if ($this->players[0]->hand->compareTo($this->players[1]->hand) == Hand::RESPONSE_WIN) {
      $winner = &$this->players[0];
    } else if ($this->players[0]->hand->compareTo($this->players[1]->hand) == Hand::RESPONSE_TIE) {
      return false;
    } else {
      $winner = &$this->players[1];
    }
    $winner->score++;
    return $winner;
  }

  /**
   * Set the hand for a defined player.
   *
   * @param {number} $playerId The player id.
   * @param {string} $handType The hand type.
   */
  public function setHandForPlayer($playerId, $handType) {
    if (empty($this->players[$playerId])) {
      throw new Exception('This player does not exist.');
    }

    if ($this->players[$playerId]->type == GamePlayer::$GAME_PLAYER_TYPES['human']) {
      $this->players[$playerId]->hand = Hand::get($handType);
    } else {
      $this->players[$playerId]->hand = Hand::getRandom();
    }
  }

  /**
   * Save the game.
   *
   * @param {boolean} $startNewRound Flag defining if a new round is being
   *   started.
   */
  public function save($newRound) {
    if ($newRound) {
      $this->roundCount++;
    }
    $_SESSION['game'] = serialize($this);
  }

  /**
   * Load the game or instantiate a new one if necessary.
   */
  public static function load() {
    if (empty($_SESSION) || empty($_SESSION['game'])) {
      return new Game();
    }
    return unserialize($_SESSION['game']);
  }
}


class GamePlayer {
  /**
   * Type of the player (human or machine)
   * @type {GamePlayer.GAME_PLAYER_TYPES}
   */
  public $type;

  /**
   * Current hand.
   * @type {Hand}
   */
  public $hand;

  /**
   * Score of the player.
   * @type {number}
   */
  public $score = 0;

  /**
   * Types of game players.
   * @type {Array.<string, string>}
   */
  public static $GAME_PLAYER_TYPES = Array(
      'human'=>'human',
      'machine'=> 'machine');

  /**
   * Set the hand of the player.
   *
   * @param {string} $hand The hand of the player.
   */
  public function setHand($hand) {
    if ($hand instanceof Hand) {
      $this->hand = $hand;
    } else {
      throw new Exception('Error - This is not a valid Hand.');
    }
  }

  /**
   * Set the type of player.
   *
   * @param {string} $type The type of the player.
   */
  public function setType($type) {
    if (!in_array($type, GamePlayer::$GAME_PLAYER_TYPES)) {
      throw new Exception('Error - This type of user is not recognized.');
    }
    $this->type = $type;
  }
}
?>