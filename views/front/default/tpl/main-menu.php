                <?php
                  function buildCategoriesTree($menu, $topLevel = true){
                    if($menu){
                      echo '<ul class="collapsible ' . ( ($topLevel) ? 'top-menu-collapsible' : 'submenu-collapsible') . '" data-collapsible="accordion">';
                      foreach($menu as $value){
                        echo '<li>';
                        echo '<div class="collapsible-header">';
                        echo '<' . (($value['submenu']) ? 'button' : 'a') . ' class="waves-effect btn" href="' . $value['url'] . '" title="' . $value['name'] . '">';
                        echo $value['name'];
                        echo ($value['submenu']) ? '</button>' : '</a>';
                        echo '</div>';
                        if($value['submenu']){
                          echo '<div class="collapsible-body">';
                          $topLevel = false;
                          buildCategoriesTree($value['submenu'], $topLevel);
                          echo '</div>';
                        }
                        
                        echo '</li>';
                      }
                      echo '</ul>';
                    }
                  }
                ?>

                <?php if($menu){ ?>
                  <div class="left-block">
                    <ul class="collapsible menu-collapsible-container" data-collapsible="expandable">
                      <li>
                        <?php /*<div class="collapsible-header <?php if(!$categoryPage){ ?>active hidden<?php } ?>">*/ ?>
                        <div class="collapsible-header active hidden">
                          <button class="btn waves-effect">
                            <span class="icon icon-menu"></span>
                            Категории сайта
                          </button>
                        </div>
                        <div class="collapsible-body">
                          <?php buildCategoriesTree($menu) ?>
                        </div>
                      </li>
                    </ul>
                  
                  </div>
                <?php } ?>