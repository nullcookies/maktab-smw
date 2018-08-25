        
        <div class="content-block info-page-container">
            <?php
                include('breadcrumbs.php');
            ?>
            <div class="container">
            
                <div class="info-page-block">
                    <h1 class="main-header">
                        <?=$infoPage['name'][LANG_ID]?>
                    </h1>
                    <div class="topic">
                        <?=htmlspecialchars_decode($infoPage['descr_full'][LANG_ID])?>
                    </div>
                </div>
            </div>
        </div>