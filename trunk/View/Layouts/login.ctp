<?php echo $this->Html->docType(); ?>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title><?php echo $title_for_layout;?></title>
    <?php echo $this->Html->css(array(
    'http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css',
    'css_styles.min'));?>
    <?php echo $this->fetch('css');?>
</head>
<body class="focusedform">
    <div class="verticalcenter">
        <?php echo $this->Html->image('jobsheets-logo-1000x550.svg', array('alt' => 'JobSheets', 'width' => '100%'));?>
        <div class="panel panel-primary">
            <?php echo $this->fetch('content');?>
        </div>
    </div>
    <?php echo $this->fetch('script');?>
</body>
</html>