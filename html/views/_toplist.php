<?php
  $scores = R::find('game', 'ended_at IS NOT NULL ORDER BY score DESC LIMIT 30');
  $rank = 1;
?>
<div class="block block-top-30">
  <div class="top-30">
    <div class="block-head">
      <h2 class="icon icon-top-30">TOP 30</h2>
      <div class="link">
        <a href="index.php?a=top">&gt; Kõik</a>
      </div>
    </div>
    <div class="top-list">
      <?php foreach ($scores as $score): ?>
        <?php
          $class = ($rank < 3) ? sprintf("position-0%d", $rank) : "";
        ?>
        <div class="position <?php echo $class;?>"><span class="number"><?php echo str_pad($rank, 2, '0', STR_PAD_LEFT);?></span></span> <?php echo lookup_name($score->user_id);?></div>
        <?php
          $rank++;
        ?>
      <?php endforeach;?>
      </div>
  </div>
</div>
