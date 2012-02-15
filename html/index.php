<?php
  error_reporting(E_ALL);
  ini_set('display_errors', true);
  
  define('TOTAL_ATTEMPTS', 3);
  define('QUIZ_TIMELIMIT', 6000); // seconds
  
  require_once(dirname(__FILE__).'/lib/rb127lg.php');
  $host = 'localhost';
  $dbname = 'hondex';
  $user = 'hondex';
  $pass = 'hondex';
  R::setup("mysql:host=$host;dbname=$dbname", $user, $pass);
  
  session_start();
  /**
   * Stub method for requiring logged in user.
   * 
   * @todo Add logic for checking that a user is logged in and redirect if not
   */
  function get_loggedin_user() {
    $user_id = 1;
    return $user_id;
  }
  
  /**
   * Stub method for figuring out user name from user_id
   */
  
  function lookup_name($user_id) {
    // Replace me with real code
    return 'User #'.$user_id;
  }
  
  function redirect($url) {
    switch ($url) {
      case 'questions':
        header('Location: index.php?a=questions');
        die();
        break;
        
      case 'result':
        header('Location: index.php?a=result');
        die();
        break;
    }
  }
  
  function attempts_left($user_id) {
    $count = R::getCell('SELECT COUNT(*) FROM game WHERE user_id = ?', array($user_id));
    return TOTAL_ATTEMPTS - $count;
  }
  
  function format_time($seconds) {
    $s = $seconds % 60;
    $m = $seconds / 60 % 60;
    $h = $seconds / 3600 % 60;
    
    return "$h:$m:$s"; 
  }
  
  function finish_game($game) {
    $game->ended_at = date('Y-m-d H:i:s', time());
    $game->score = calculate_score($game);
    
    R::store($game);
  }
  
  function calculate_score($game) {
    $time_score = (QUIZ_TIMELIMIT - (strtotime($game->ended_at) - strtotime($game->started_at)));
    
    $quiz_score = calculate_quiz_score($game);
        
    return $quiz_score + $time_score;
  }

  function calculate_quiz_score($game) {
    $quiz_score = 0;
    
    $answer_ids = array();
    $user_answers = unserialize($game->answers);
    
    foreach ($user_answers as $answer) {
      $answer_ids[] = $answer['answer'];
    }
    
    $correct_answers = R::find('answer', 'is_correct = 1');
    
    foreach ($correct_answers as $answer) {
      if (in_array($answer->id, $answer_ids)) {
        $quiz_score += 1000;
      }
    }
    
    return $quiz_score;
  }
  
  function user_can_participate($user_id) {
    $game = R::findOne('game', 'started_at > ?', array(date('Y-m-d H:i:s', strtotime('-1 week'))));
    return ($game === false);
  }
  
  function user_has_open_quiz($user_id) {
    $game = R::findOne('game', 'ended_at IS NULL && started_at > ?', array(date('Y-m-d H:i:s', strtotime('-'.QUIZ_TIMELIMIT))));
    return $game;
  }
  /*
   * get "/"
   */
  if (empty($_GET)) {
    $user_id = get_loggedin_user();
    
    $game = user_has_open_quiz($user_id);
    if ($game !== false) {
      $_SESSION['quiz_id'] = $game->id;
      redirect('questions');
    }
    
    $user_can_participate = user_can_participate($user_id);
    include_once('views/test-start.php');
  }
  
  if (isset($_GET['a'])) {
    $action = $_GET['a'];
  } else {
    $action = null;
  }
  
  /*
   * get /start
   */

  if ($action == 'start') {
    $game = R::dispense('game');
    $game->started_at = date('Y-m-d H:i:s', time());
    $game->user_id = get_loggedin_user();
    $game->ended_at = null;
    $game->score = 0;
    
    // load questions
    $questions = R::find('question');
    $answers = array();
    foreach ($questions as $question) {
      $answers[] = array('question' => $question->id, 'answer' => null, 'timestamp' => time());
    }
    
    $game->answers = serialize($answers);
    
    R::store($game);
    
    
    $_SESSION['quiz_id'] = $game->id;
    
    redirect('questions');
  }
  
  if ($action == 'questions') {
    $game = R::load('game', $_SESSION['quiz_id']);
    
    if (($question_id = find_first_unanswered_question(unserialize($game->answers))) == null) {
      redirect('result');
    }
    
    $question = R::load('question', $question_id);
    $answers = R::find('answer', 'question_id = ? ORDER BY RAND()', array($question_id));
    
    $seconds_left = strtotime($game->started_at) - time() + QUIZ_TIMELIMIT;
    
    include_once(dirname(__FILE__).'/views/test-middle.php');
  }
  
  if ($action == 'answer') {
    $chosen_answer = $_POST['answer'];
    $answer = R::load('answer', $chosen_answer);
    $question_id = $answer->question_id;
    
    $game = R::load('game', $_SESSION['quiz_id']);
    $answers = unserialize($game->answers);
    foreach ($answers as &$answer) {
      if ($answer['question'] == $question_id) {
        $answer['answer'] = $chosen_answer;
      }
    }
    $game->answers = serialize($answers);
    
    // if all questions are answered - redirect to finish
    $unanswered = 0;
    foreach ($answers as $answer) {
      if ($answer['answer'] == null) {
        $unanswered++;
      }
    }
    
    if ($unanswered == 0) {
      finish_game($game);
      redirect('result');
    }
    
    R::store($game);
    
    redirect('questions');
  }
  
  function find_first_unanswered_question($answers) {
    $question_id = null;
    foreach ($answers as $answer) {
      if ($question_id == null && $answer['answer'] == null) {
        $question_id = $answer['question'];
      }
    }
    
    return $question_id;
  }
  
  if ($action == 'result') {
    $game = R::load('game', $_SESSION['quiz_id']);
    
    $user_answers = unserialize($game->answers);
    
    $question_id = find_first_unanswered_question($user_answers);
    if ($question_id != null) {
      redirect('questions');
    }
    
    $total_score = calculate_score($game);
    $quiz_score = calculate_quiz_score($game);
    
    $rank = R::getCell('SELECT COUNT(*) FROM game WHERE score > ?', array($total_score)) + 1;
    $attempts_left = attempts_left($game->user_id);
    
    include_once('views/test-end.php');
  }

  if ($action == 'top') {
    if (isset($_GET['p'])) {
      $page = $_GET['p'];
    } else {
      $page = 1;
    }
    
    $scores = R::find('game', 'ended_at IS NOT NULL ORDER BY score DESC');
    
    include_once('views/top.php');
  }
