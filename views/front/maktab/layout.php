<!doctype html>
<html>
<head>   
    <meta charset="<?=$document->charset?>">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="<?=$document->description?>">
    <meta name="keywords" content="<?=$document->keywords?>">
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
    <link rel="stylesheet" type="text/css" href="<?= THEMEURL ?>/css/vendor.css" />

    <!-- Theme initialization -->
    <script>
        var cssUrl = '<?= THEMEURL ?>/css';
        var themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
        {};
        var themeName = themeSettings.themeName || '';
        if (themeName)
        {
            document.write('<link rel="stylesheet" id="theme-style" href="' + cssUrl + '/app-' + themeName + '.css">');
        }
        else
        {
            document.write('<link rel="stylesheet" id="theme-style" href="' + cssUrl + '/app.css">');
        }
    </script>

    <link rel="stylesheet" type="text/css" href="<?= THEMEURL ?>/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= THEMEURL ?>/plugins/datatables/datatables.css" />
    <link rel="stylesheet" type="text/css" href="<?= THEMEURL ?>/css/main.css" />

</head>
<body class="<?=implode(' ', $document->bodyClass)?>">
    <div class="main-wrapper">
        <div class="app" id="app">
    
    
            <?php if(isset($header) && $header != false){ ?>
            <!-- header -->
            <?=$header?>
            <!-- end header -->
            <?php } ?>


            <?php if(isset($sidebar) && $sidebar != false){ ?>
            <!--  sidebar -->
            <?=$sidebar?>
            <!--  /sidebar -->
            <?php } ?>

            <?php if(isset($content) && $content != false){ ?>
            <!--  content -->
            <?=$content?>
            <!-- /content -->
            <?php } ?>
                
            <?php if(isset($footer) && $footer != false){ ?>
            <!-- footer -->
            <?=$footer?>
            <!-- end footer -->
            <?php } ?>

        </div>
    </div>
    <!-- .main-wrapper -->
    

    <!-- Reference block for JS -->
    <div class="ref" id="ref">
        <div class="color-primary"></div>
        <div class="chart">
            <div class="color-primary"></div>
            <div class="color-secondary"></div>
        </div>
    </div>

    <script type="text/javascript" src="<?= THEMEURL ?>/js/vendor.js"></script>
    <?php if(!empty($document->scripts)) { ?>
    <?php foreach($document->scripts as $script ){ ?>
    <script type="text/javascript" src="<?= $script; ?>"></script>
    <?php } ?>
    <?php } ?>

    <script type="text/javascript" src="<?= THEMEURL ?>/plugins/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="<?= THEMEURL ?>/plugins/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="<?= THEMEURL ?>/plugins/moment/locale/ru.js"></script>
    <script type="text/javascript" src="<?= THEMEURL ?>/plugins/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js"></script>

    <script type="text/javascript" src="<?= THEMEURL ?>/js/app.js"></script>


    <?php 
        //add analytics codes
        $analytics = $this->getOption('analytics');
        if($analytics != 'analytics'){
            echo htmlspecialchars_decode($analytics, ENT_QUOTES);
        }
    ?>
</body>



</html>