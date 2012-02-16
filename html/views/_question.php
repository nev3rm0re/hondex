      <div class="content">
          <div class="q-content">
            <div class="q-number">
              <span class="current"><?php echo $question->id; ?></span>/21
            </div>
            
            <div class="question">
              <form action="index.php?a=answer" id="answer_form" method="post">
                <h2><?php echo $question->text;?></h2>
                
                <?php foreach ($answers as $answer): ?>
                  <div class="form-radio-wrap">
                    <label><?php echo $answer->text;?><input type="radio" name="answer" value="<?php echo $answer->id; ?>" class="form-radio"/></label>
                  </div>  
                <?php endforeach; ?>
                
                <div class="clear"></div>
                
                <div class="button">
                  <a href="#" id="answer_btn"><span>Valmis - Järgmine küsimus</span></a>
                </div>
                <input type="submit" value="" style="display:none" />
              </form>
            </div>
          </div>
          <div class="clear"></div>
        </div>