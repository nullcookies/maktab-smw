<!DOCTYPE html>
<html>
<head>
	<meta charset="<?= $document->charset ?>" />
    <meta name="description" content="<?= $document->description ?>" />
    <meta name="keywords" content="<?= $document->keywords ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<?php //if($document->canonical) { ?><!--<link rel="canonical" href="--><?//= $document->canonical ?><!--" />--><?php //} ?>

    <?php if($document->favicon) { ?>
        <link rel="shortcut icon" href="<?= $document->favicon ?>" />
    <?php } ?>
                
    <title><?= $document->title; ?></title>
    
    <link rel="stylesheet" type="text/css" href="<?= THEMEURL_ADMIN . '/styles/vendor.css'; ?>" />
<?php if(!empty($document->styles)) foreach($document->styles as $style){ ?>
    <link rel="stylesheet" type="text/css" href="<?= $style; ?>" />
<?php } ?>
    <link rel="stylesheet" type="text/css" href="<?= THEMEURL_ADMIN . '/styles/AdminLTE.css'; ?>" />
    <link rel="stylesheet" type="text/css" href="<?= THEMEURL_ADMIN . '/styles/skins/skin-blue.css'; ?>" />
    <link rel="stylesheet" type="text/css" href="<?= THEMEURL_ADMIN . '/styles/main.css'; ?>" />
    
    <script type="text/javascript" src="<?= THEMEURL_ADMIN . '/scripts/jquery.js'; ?>"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="<?= THEMEURL_ADMIN . '/scripts/vendor.js'; ?>"></script>

<?php if(!empty($document->scripts)) { ?>
<?php foreach($document->scripts as $script ){ ?>
    <script type="text/javascript" src="<?= $script; ?>"></script>
<?php } ?>
<?php } ?>

    <script type="text/javascript" src="<?= THEMEURL_ADMIN . '/scripts/app.min.js'; ?>"></script>
    <script type="text/javascript" src="<?= THEMEURL_ADMIN . '/scripts/main.js'; ?>"></script>
</head>

<body class="hold-transition sidebar-mini <?php echo (empty($document->bodyClass) ? 'skin-blue' : $document->bodyClass); ?>">

<div class="wrapper">
	
	
	<?php if(isset($header) && $header != false){ ?>
    <!-- header -->
        <?=$header?>
    <!-- end header -->
    <?php } ?>
    
	
    <?php if(isset($sidebar) && $sidebar != false){ ?>
    <!--  sidebar -->
		<?=$sidebar?>
    <!-- end sidebar -->
    <?php } ?>
    
	
	<?php if(isset($content) && $content != false){ ?>
	<!-- Content Wrapper. Contains page content -->
	<?=$content?>
	<!-- /.content-wrapper -->
	<?php } ?>
	
        
    <?php if(isset($footer) && $footer != false){ ?>
    <!-- footer -->
        <?=$footer?>
    <!-- end footer -->
    <?php } ?>
	
	<?php if(isset($controlSidebar) && $controlSidebar != false){ ?>
    <!--  controlSidebar -->
		<?=$controlSidebar?>
    <!-- end controlSidebar -->
    <?php } ?>

	
</div>
<!-- ./wrapper -->



	
	
</body>
</html>