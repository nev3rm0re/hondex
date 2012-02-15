<?php
  require_once(dirname(__FILE__).'/lib/rb127lg.php');
  R::setup('mysql:host=localhost;dbname=hondex', 'hondex', 'hondex');
  
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
  
  function redirect($url) {
    switch ($url) {
      case 'questions':
        header('Location: index.php?a=questions');
        die();
        break;
    }
  }
  
  /*
   * get "/"
   */
  if (empty($_GET)) {
    $user_id = get_loggedin_user();
    include_once('views/test-start.php');
  }
  
  if (isset($_GET['a'])) {
    $action = $_GET['a'];
  }

  if ($action == 'start') {
    $game = R::dispense('game');
    $game->started_at = date('Y-m-d H:i:s', time());
    $game->user_id = get_loggedin_user();
    $game->ended_at = null;
    
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
    
    // figure out the question
    $answers = unserialize($game->answers);
    $question_id = null;
    foreach ($answers as $answer) {
      if ($question_id == null && $answer['answer'] == null) {
        $question_id = $answer['question'];
      }
    }
    if ($question_id == null) {
      $question_id = 1;
    }
    
    $question = R::findOne('question', $question_id);
    $answers = R::find('answer', 'question_id = ?', array($question_id));
    
    include_once(dirname(__FILE__).'/views/test-middle.php');
  }
  
  if ($action == 'answer') {
    $chosen_answer = $_POST['answer'];
    $answer = R::load('answer', $chosen_answer);
    $question_id = $answer->question_id;
    
    $game = R::load('game', $_SESSION['quiz_id']);
    $answers = unserialize($game->answers);
    foreach ($answers as &$answer) {
      if ($answer['question_id'] == $question_id) {
        $answer['answer'] = $chosen_answer;
      }
    }

    $game->answers = serialize($answers);
    R::store($game);
    
    redirect('questions');
  }
