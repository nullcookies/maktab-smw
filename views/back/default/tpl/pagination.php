<ul class="pagination">
    <?php if($pagination['first']){ ?>
        <li>
            <a class="" href="<?=$pagination['first']?>">&laquo;<span class="hidden-xs"> Первый</span></a>
        </li>
    <?php } ?>
    <?php if($pagination['prev']){ ?>
        <li>
            <a class="" href="<?=$pagination['prev']?>">&lt;</a>
        </li>
    <?php } ?>

    <?php if($pagination['prev_group']){ ?>
        <li>
            <a class="" href="<?=$pagination['prev_group']?>">...</a>
        </li>
    <?php } ?>

    <?php foreach($pagination['pages'] as $key => $value){ ?>
        <?php if($pagination['active'] != $key){ ?>
            <li><a href="<?=$value?>"><?=$key?></span></a></li>
        <?php } else { ?>
            <li class="active"><a href="#"><?=$key?></a></li>
        <?php } ?>
    <?php } ?>

    <?php if($pagination['next_group']){ ?>
        <li>
            <a class="" href="<?=$pagination['next_group']?>">...</a>
        </li>
    <?php } ?>

    <?php if($pagination['next']){ ?>
        <li>
            <a class="" href="<?=$pagination['next']?>">&gt;</a>
        </li>
    <?php } ?>
    <?php if($pagination['last']){ ?>
        <li>
            <a class="" href="<?=$pagination['last']?>"><span class="hidden-xs">Последний </span>&raquo;</a>
        </li>
    <?php } ?>
</ul>