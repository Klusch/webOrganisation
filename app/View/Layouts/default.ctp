<?php
  $cakeDescription = __d('cake_dev', "Alex's little management");
?>

<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        
        <title>
                <?php echo $cakeDescription ?>:
                <?php echo $title_for_layout."\n"; ?>
        </title>

<?php
    echo $this->Html->css('metro/metro-bootstrap', array('media' => 'screen'))."\n".
         $this->Html->css('metro/metro-bootstrap-responsive', array('media' => 'screen'))."\n".
         $this->Html->css('metro/iconFont', array('media' => 'screen'))."\n".
         $this->Html->css('jquery-ui-widget/jquery-ui', array('media' => 'screen'))."\n".
         $this->Html->css('kluge/metro-customized', array('media' => 'screen'))."\n".            
         $this->Html->css('kluge/kluge', array('media' => 'screen'))."\n".
         $this->Html->css('kluge/kluge-responsive', array('media' => 'screen'))."\n"
         ;
         
    echo $this->Html->script('jquery/jquery-1.11.1.js')."\n".
         $this->Html->script('jquery/jquery-ui-widget-1.11.1.js')."\n".
         $this->Html->script('metro/metro-loader.js')."\n";
?>

</head>

<?php 
   $background = $this->fetch('background');

   if ($background == null) {
       $background = $this->params['controller'];
   }
?>

<body class="metro <?php echo $background; ?>">

   
    
  <noscript>
    <div id='flash-message' class='input-control text warning-state' data-role='input-control'>
        <?php  echo "<input value='".__('You have to activate javascript to use this application')."' type='text'>\n"; ?>
    </div>
  </noscript>
    
  <header class="bg-default" data-load="" style="margin-top:-14px">
  <?php
     $user = $this->Session->read('Auth.User');
     echo $this->Nav->topBar($user);
  ?>     
  </header>

  
   
<div class="container"> 

    <?php echo $this->Session->flash(); ?>
    <?php echo $this->fetch('breadCrumbs');?>  
      
    <!-- Upper menu -->
    <div class="grid">
      <?php
        $tmp = $this->fetch('topTiles');
        if (!empty($tmp)) {
           echo "<div class='row'>"
                        . $this->fetch('topTiles') .
                "</div>";
        }
      ?> 
    </div>   
        
    <!-- Content-Area -->
    <div>
        <div id="contentWithTiles" class="row right" <?php if ($this->fetch('fullSize') == 'true') { echo " style='width:100%'"; } ?>> 
                <div class='<?php echo $this->params['controller'] ?>' id='content-hgl' style='  
                    <?php echo ($this->fetch('frameRequest') == 'true') 
                       ? " padding:15px;"
                       : " padding:0px; border:0px;"?>'>
                    <?php echo $this->fetch('content'); ?>
                </div>
         </div>
        <?php echo $this->fetch('dynamicContent'); ?>
    </div>

  </div>
  
<!-- JavaScript -->
<!-- global -->
<?php  echo $this->Html->script('kluge/custom-messages.js') . "\n"; ?>
<?php  echo $this->Html->script('kluge/content-resizer.js') . "\n"; ?>

<!-- local -->
<?php echo $this->fetch('pageScripts')."\n";?>
<!-- End JavaScript -->

</body>
</html>
