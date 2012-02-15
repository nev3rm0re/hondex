<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Honda</title>
  <link rel="stylesheet" href="css/fancybox.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="css/uniform.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
  <script src="js/jquery.js" type="text/javascript"></script>
  <script src="js/cufon.js" type="text/javascript"></script>
  <script src="js/honda.font.js" type="text/javascript"></script>
  <script src="js/jquery.countdown.js" type="text/javascript"></script>
  <script src="js/jquery.easing.js" type="text/javascript"></script>
  <script src="js/jquery.mousewheel.js" type="text/javascript"></script>
  <script src="js/jquery.fancybox.js" type="text/javascript"></script>
  <script src="js/jquery.uniform.js" type="text/javascript"></script>
  <script src="js/script.js" type="text/javascript"></script>
</head>
<body>
<div id="wrapper">
  <div id="header">
    <div class="inner">
      <div class="keypoints">
        <img src="images/keypoints.png" alt=""/>
      </div>
      
      <div class="login">
        <div class="form-item">
          <label>Kasutajanimi</label>
          <input type="text" class="form-text"/>
        </div>
        <div class="form-item">
          <label>Parool</label>
          <input type="password" class="form-text"/>
        </div>        
        <div class="remember">
          <label><input type="checkbox" class="checkbox"/> Jäta mind meedle</label>
        </div>
        <div class="form-actions">
          <input type="image" src="images/button-login.png" alt="Logi sisse"/>
          <div class="register">
            <a href="#">Loo konto</a>
          </div>
        </div>
      </div>
      <div class="clear"></div>
      <div class="menu">
        <ul>
          <li class="first"><a href="#">Tutvustus</a></li>
          <li class="active"><a href="#">Kvalifikatsioon</a></li>
          <li><a href="#">Ekspeditsioon</a></li>
          <li><a href="#">Galerii</a></li>
          <li><a href="#">Kontakt</a></li>
        </ul>
        <div class="like">
          <iframe src="https://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.honda.ee%2F&amp;send=false&amp;layout=button_count&amp;width=119&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:119px; height:21px;" allowTransparency="true"></iframe>
        </div>
      </div>
      
      <div class="countdown">
        <div class="label">Aega ekspeditsioonini:</div>
        <div class="time">20:12:32:15</div>
      </div>
      
      <div class="logo">
        <a href="index.html"><img src="images/honda-civic-expedition.png" alt=""/></a>
      </div>
    </div>
  </div>
  <div id="container">
    <div class="inner">
      <div id="content">
        <div class="head">
          <h2 class="icon icon-qualification">Kvalifikatsioon</h2>
          <div class="timer" id="javascript_countdown_time">
            01:40:00
          </div>
        </div>
        <div class="content">
          
          <div class="q-content">
            <div class="q-number">
              <span class="current">0</span>/21
            </div>
            
            <div class="start">
              <?php if ($user_can_participate): ?>
              Stop - Esmalt soovitame tutvuda <strong><a href="">JUHENDIGA</a></strong>!
              <div class="button">
                <a href="index.php?a=start"><span>Alusta kvalifikatsiooni</span></a>
              </div>
              <?php else: ?>
                Oled sel nädalal juba Civicu teadmistetesti sooritanud! Proovi järgmisel nädalal kindlasti uuesti!
              <?php endif;?>
            </div>
            
          </div>
          
          <div class="clear"></div>
        </div>
      </div>
      <div id="sidebar">
        <div class="block">
          <div class="info">
            <h2>Lisainfo</h2>
            <div class="menu">
              <ul>
                <li><a href="#">&gt; Kvalifitseeru</a></li>
                <li class="special"><a href="#">&gt; Ekspeditsioon</a></li>
                <li><a href="#">&gt; Galerii</a></li>
              </ul>
            </div>
          </div>
        </div>

        <?php include_once(dirname(__FILE__).'/_toplist.php'); ?>
        
      </div>
      <div class="clear"></div>
    </div>
  </div>
  <div id="footer">
    <div class="inner">
      <div class="copy">
        <h2>Honda Civic Expedition 2012</h2>
        <p>All RIGHTS RESERVED - Honda Baltic 2012</p>
      </div>
      <div class="like">
        <iframe src="https://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.honda.ee%2F&amp;send=false&amp;layout=button_count&amp;width=119&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:119px; height:21px;" allowTransparency="true"></iframe>
      </div>
    </div>
  </div>
</div>
</body>
</html>