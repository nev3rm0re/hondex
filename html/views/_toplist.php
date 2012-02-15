<?php
  $scores = Quiz::getTopScores();
?>
<?php foreach ($scores as $n => $score): ?>
  <?php
    $class = ($n < 3) ? sprintf("position-0%d", $n + 1) : "";
  ?>
  <div class="position <?php echo $class;?>"><span class="number"><?php echo str_pad($n, 2, '0', STR_PAD_LEFT);?></span></span> <?php echo $score["name"];?></div>
<?php endforeach;?>