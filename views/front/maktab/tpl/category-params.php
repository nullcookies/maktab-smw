<div id="category-params">
  <?php if($filters){ ?>
  <?php
    $colorNames = ['Цвет', 'Color', 'Rang'];
  ?>
  <div class="container">
    <div class="content-block">
      <form id="category-params-form" action="<?=$categoryBaseUrlOptions?>" method="post">

        <input type="hidden" name="tag" value="<?=$tag_id?>">
        <input type="hidden" name="brand" value="<?=$brand_id?>">

        <h3 class="left-block-header">
          <?=$this->translation('filters')?>:
        </h3>
        <div class="filters-list">
          
          <?php foreach($filters as $value){ ?>
          <div class="filter-block">
            <h3 class="filter-block-name">
              <?=$value['name']?>
            </h3>
            <ul class="filter-block-ul">
              <?php foreach($value['values'] as $v){ ?>
              <li class="filter-block-li">
                <input type="checkbox" class="" name="filter[<?=$v['id']?>]" id="filter_<?=$v['id']?>" <?php if(in_array($v['id'], $filterValueIds)){ ?>checked<?php } ?>>
                <label for="filter_<?=$v['id']?>">
                  <span class="filter-name"><?=$v['name']?></span>
                  <?php if($v['color'] && in_array($value['name'], $colorNames)){ ?>
                  <span class="filter-badge filter-color" style="background-color: <?=$v['color']?>"></span>
                  <?php } ?>
                </label>
              </li>
              <?php } ?>
            </ul>
          </div>
          <?php } ?>

          <button title="<?=$this->translation('apply')?>" type="submit" class="filter-btn btn btn-success">
            <i class="fa fa-check"></i>
          </button>
          <a title="<?=$this->translation('clear filter')?>" href="<?=$categoryBaseUrl?>" class="btn btn-danger">
            <i class="fa fa-times"></i>
          </a>

        </div>
      </form>
    </div>
  </div>
  <?php } ?>

  <?php /*if($brands){ ?>
  <div class="left-block">
    <div class="left-box">
      <h3 class="left-block-header">
        <?=$this->translation('manufacturers')?>
      </h3>
      <div class="brands-list">
        <?php foreach($brands as $value){ ?>
        <a class="brands-list-item <?php if($value['id'] == $brand_id){ ?>active<?php } ?>" href="<?=$value['url']?>" >
          <?=$value['name'][LANG_ID]?>
        </a>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php } ?>

  <?php if($tags){ ?>
  <?php
  shuffle($tags);
  ?>
  <div class="left-block">
    <div class="left-box">
      <h3 class="left-block-header">
        <?=$this->translation('tags')?>
      </h3>
      <div class="filter-tags">
        <?php foreach($tags as $value){ ?>
        <?php 
          $fontSize = floor($value['cnt'] / 1) + 15;
          if($fontSize > 24){
            $fontSize = 24;
          }
        ?>
        <a style="font-size:<?=$fontSize?>px;" class="dark-text <?php if($value['id'] == $tag_id){ ?>active<?php } ?>" href="<?=$categoryBaseUrl?>?tag=<?=$value['id']?>" >
          <?=$value['name']?>
        </a>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php } */?>

</div>