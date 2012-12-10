<?php
/**
 * Hand interface.
 *
 * All Hand objects should have the method compareToHand implemented.
 *
 * @author michael@xethorn.net (Michael Ortali)
 */
interface HandInterface {
  /**
   * Compare one hand with another one.
   *
   * @param {Hand} $hand The hand to compare the current hand with.
   */
  public function compareTo($hand);
}


/**
 * Hand Model class.
 *
 * Mostly composed of constant. They are used to determine if a hand can win
 * against another hand.
 *
 * @author michael@xethorn.net (Michael Ortali)
 */
class Hand {
  /**
   * @type {string}
   * @const
   */
  const RESPONSE_WIN = 'win';

  /**
   * @type {string}
   * @const
   */
  const RESPONSE_LOSE = 'lose';

  /**
   * @type {string}
   * @const
   */
  const RESPONSE_TIE = 'tie';

  /**
   * Allowed hands.
   */
  public static $allowedHands = array('HandRock', 'HandPaper',
      'HandScissors');

  /**
   * Get hand from a string.
   *
   * @param {string} str The string that corresponds to the Hand.
   * @return {Hand}
   * @static
   */
  public static function get($hand) {
    if (in_array($hand, Hand::$allowedHands)) {
      return new $hand();
    }
    throw new Exception('This hand is not supported.');
  }

  /**
   * Get random hand.
   *
   * @return {Hand}
   */
  public static function getRandom() {
    shuffle(Hand::$allowedHands);
    $hand = Hand::$allowedHands[0];
    return new $hand();
  }
}


/**
 * Hand Rock.
 *
 * Wins against Hand Scissors, looses against Hand Paper.
 */
class HandRock extends Hand implements HandInterface {
  /** @override */
  public function compareTo($hand) {
    if ($hand instanceof HandScissors) {
      return Hand::RESPONSE_WIN;
    } elseif ($hand instanceof HandPaper) {
      return Hand::RESPONSE_LOSE;
    } else {
      return Hand::RESPONSE_TIE;
    }
  }

  /** @override */
  public function toString() {
    return 'Rock';
  }
}


/**
 * Hand Scissors.
 *
 * Wins against Hand Scissors, looses against Hand Paper.
 */
class HandScissors extends Hand implements HandInterface {
  /** @override */
  public function compareTo($hand) {
    if ($hand instanceof HandPaper) {
      return Hand::RESPONSE_WIN;
    } elseif ($hand instanceof HandRock) {
      return Hand::RESPONSE_LOSE;
    } else {
      return Hand::RESPONSE_TIE;
    }
  }

  /** @override */
  public function toString() {
    return 'Scissors';
  }
}


/**
 * Hand Paper.
 *
 * Wins against Hand Rock, looses against Hand Scissors.
 */
class HandPaper extends Hand implements HandInterface {
  /** @override */
  public function compareTo($hand) {
    if ($hand instanceof HandScissors) {
      return Hand::RESPONSE_LOSE;
    } elseif ($hand instanceof HandRock) {
      return Hand::RESPONSE_WIN;
    } else {
      return Hand::RESPONSE_TIE;
    }
  }

  /** @override */
  public function toString() {
    return 'Paper';
  }
}
?>