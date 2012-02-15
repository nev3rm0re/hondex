<?php
  error_reporting(E_ALL);
  ini_set('display_errors', true);
  
  require_once(dirname(__FILE__).'/../lib/rb127lg.php');
  R::setup('mysql:host=localhost;dbname=hondex', 'hondex', 'hondex');
  
  $lines = file('questions.php');
  
  foreach ($lines as $line) {
    if (preg_match('/(\d+)\.(.*)$/', $line, $matches)) {
      $question = R::findOne('question', 'text = ?', array(trim($matches[2])));
      if (!$question) {
        $question = R::dispense('question');
        $question->text = trim($matches[2]);
        R::store($question);
      } else {
        echo "Q is present<br />";
      }
    }
    
    if (preg_match('/([a-c])\.(.*)$/', $line, $matches)) {
      $answer = R::dispense('answer');
      $answer->question_id = $question->id;
      $answer->text = $matches[2];
      $answer->unique_id = uniqid();
      $answer->is_correct = ($matches[1] == 'a') ? 1: 0;
      R::store($answer);
    }
  }
?>