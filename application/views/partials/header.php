<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
		
	<title><?php echo $title ?></title>
   <link rel="stylesheet" href="/forever/assets/css/bootstrap.min.css" />
	<?php $layout = $this->input->get('layout', TRUE); ?>
  <?php if($layout == 'responsive') : ?>
    <link rel="stylesheet" href="/forever/assets/css/bootstrap-responsive.min.css" /> 
  <?php endif;?>
    <link rel="stylesheet" href="/forever/assets/css/style.css" />
    
	<script type="text/javascript" src="http://www.google.com/jsapi"></script>
	<script type="text/javascript">
		//<!--
		google.load('jquery', '1.7.1');
		//-->
	</script>
  <script type="text/javascript" src="/forever/assets/js/bootstrap.min.js" ></script>
	<script type="text/javascript" src="/forever/assets/js/script.js" ></script>

</head>

<body id="<?php echo isset($bodyID) ? $bodyID : ''; ?>">
  <div class="container">
    <div class="navbar navbar-inverse" style="position: static;">
        <div class="navbar-inner">
          <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#"><?php echo $title ?></a>
            <div class="nav-collapse collapse navbar-inverse-collapse">
              <?php if($loggedIn){ ?>
              <ul class="nav">
               <li class="<?php echo ($bodyID == 'home-index') ? 'active' : ''; ?>"><a href="/">Home</a></li>
              </ul>
              <ul class="nav pull-right">
                <li><a href="/auth/logout">Logout</a></li>
              </ul>
              <?php } ?>
            </div><!-- /.nav-collapse -->
          </div>
        </div><!-- /navbar-inner -->
      </div>

      <?php
      // display all messages
      if (is_array($messages)):
        foreach ($messages as $type => $msgs):
          foreach ($msgs as $message):
            echo ('<span class="' .  $type .'">' . $message . '</span>');
          endforeach;
        endforeach;
      endif;
      ?>
