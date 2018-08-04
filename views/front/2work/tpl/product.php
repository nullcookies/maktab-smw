        <?php
            include('breadcrumbs.php');
        ?>
        <div class="content-block content-block-30 project-view">
          <div class="container-fluid">

            <ul class="nav nav-pills" role="tablist">
              <li role="presentation" class="active">
                <a href="#list-view">List View</a>
              </li>
              <li role="presentation">
                <a href="#map-view">Map View</a>
              </li>
            </ul>


            <h1 class="main-header projects-header">
              <?=$name?>
            </h1>


            <?php if($products){ ?>
            <div class="projects-list">
              <div class="table-responsive">
                <table class="table project-table">
                  <thead>
                    <tr>
                      <th class="photo">Photo</th>
                      <th>Projects</th>
                      <th>Area</th>
                      <th>Developer</th>
                      <th>Use</th>
                      <th>Life style</th>
                      <th class="price">Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($products as $value){ ?>
                      <tr>
                        <td>
                          <a href="<?=$value['url']?>">
                            <img src="<?=$value['icon']?>" alt="<?=$value['icon'][LANG_ID]?>">
                          </a>
                        </td>
                        <td>
                          <a href="<?=$value['url']?>">
                            <?=$value['name'][LANG_ID]?>
                          </a>
                        </td>
                        <td>
                          <a href="#">
                            <?=$value['c_name'][LANG_ID]?>
                          </a>
                        </td>
                        <td>
                          <a href="#">
                            <?=$value['b_name'][LANG_ID]?>
                          </a>
                        </td>
                        <td>
                          <a href="#">
                            <?=$this->translation('project use ' . $value['project_use'])?>
                          </a>
                        </td>
                        <td>
                          <a href="#">
                            <?=$this->translation('project life style ' . $value['project_life_style'])?>
                          </a>
                        </td>
                        <td class="price">
                          AED 13,000,000
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              
              <?php //if($nav){ ?>
              <?php if(true){ ?>
              <nav class="sort-bottom" aria-label="Page navigation">
                <ul class="pagination">
                  <li>
                    <a href="#" aria-label="Previous">
                      <span aria-hidden="true">
                        <i class="fa fa-angle-double-left"></i>
                      </span>
                    </a>
                  </li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li class="active"><a href="#">3</a></li>
                  <li>of</li>
                  <li><a href="#">7</a></li>
                  <li>
                    <a href="#" aria-label="Next">
                      <span aria-hidden="true">
                        <i class="fa fa-angle-double-right"></i>
                      </span>
                    </a>
                  </li>
                </ul>
                <div class="display-nav">
                  <span class="display-nav-text">Display:</span>
                  <select name="display_qty" class="selectpicker" data-width="auto" data-style="btn-sm btn-default">
                    <option value="5">5</option>
                    <option value="10">10</option>
                  </select>
                </div>
              </nav>
              <?php } ?>
            </div>
            <?php } ?>

          </div>
        </div>

        <?php if($textName || $textContent){ ?>
        <div class="content-block" >
          <div class="container-fluid">
            <div class="main-box">
              <h2 class="main-box-header"><?=$textName?></h2>
              <div class="main-box-text">
                <?=$textContent?>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>

