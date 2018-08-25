<!DOCTYPE HTML>
<html>

<head>   

    <meta charset="<?=$document->charset?>">
    <meta name="description" content="<?=$document->description?>">
    <meta name="keywords" content="<?=$document->keywords?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php if($document->canonical) { ?><link rel="canonical" href="<?=$document->canonical ?>"><?php } ?>

	<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
    <?php if($document->favicon) { ?><link rel="shortcut icon" href="<?= $document->favicon ?>" /><?php } ?>
                
    <title><?= $document->title; ?></title>
    
    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,700&amp;subset=cyrillic" rel="stylesheet"> -->

<?php if(!empty($document->styles)) foreach($document->styles as $style){ ?>
    <link rel="stylesheet" type="text/css" href="<?= $style; ?>" />
<?php } ?>
    <link rel="stylesheet" type="text/css" href="<?= THEMEURL ?>/styles/vendor.css" />
    <link rel="stylesheet" type="text/css" href="<?= THEMEURL ?>/styles/main.css" />
    
</head>

<body>
<div id="page-wrapper">
    
    
    <?php if(isset($header) && $header != false){ ?>
    <!-- header -->
    <?=$header?>
    <!-- end header -->
    <?php } ?>
        

    <?php if(isset($top) && $top != false){ ?>
    <!-- top -->
    <div id="top">
        <?=$top?>
    </div>
    <!-- /top -->
    <?php } ?>


    <?php if(isset($left) && $left != false){ ?>
    <!--  left -->
    <?=$left?>
    <!--  /left -->
    <?php } ?>

    <?php if(isset($content) && $content != false){ ?>
    <!--  content -->
    <?=$content?>
    <!-- /content -->
    <?php } ?>

    <?php if(isset($right) && $right != false){ ?>
    <!--  right -->
    <?=$right?>
    <!-- /right -->
    <?php } ?>
    

    <?php if(isset($bottom) && $bottom != false){ ?>
    <!-- bottom -->
    <div id="bottom">
        <?=$bottom?>
    </div>
    <!-- end bottom -->
    <?php } ?>
        
    <?php if(isset($footer) && $footer != false){ ?>
    <!-- footer -->
    <?=$footer?>
    <!-- end footer -->
    <?php } ?>

</div>
<!-- .main-wrapper -->
    
    <script type="text/javascript" src="<?= THEMEURL ?>/scripts/vendor.js"></script>
<?php if(!empty($document->scripts)) { ?>
<?php foreach($document->scripts as $script ){ ?>
    <script type="text/javascript" src="<?= $script; ?>"></script>
<?php } ?>
<?php } ?>
	<!--[if lte IE 8]><script src="<?= THEMEURL ?>/src/ie/respond.min.js"></script><![endif]-->
    <script type="text/javascript" src="<?= THEMEURL ?>/scripts/main.js"></script>
    <?php 
        //add analytics codes
        $analytics = $this->getOption('analytics');
        if($analytics != 'analytics'){
            echo htmlspecialchars_decode($analytics, ENT_QUOTES);
        }
    ?>
</body>



</html>