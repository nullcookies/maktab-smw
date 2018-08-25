<header class="header">
    <div class="header-block header-block-collapse d-lg-none d-xl-none">
        <button class="collapse-btn" id="sidebar-collapse-btn">
            <i class="fa fa-bars"></i>
        </button>
    </div>
    <div class="header-block header-block-search">
        <!-- <form role="search" action="<?=$searchUrl?>">
            <div class="input-container">
                <i class="fa fa-search"></i>
                <input type="search" name="search" placeholder="Search">
                <div class="underline"></div>
            </div>
        </form> -->
    </div>
    <div class="header-block header-block-buttons">
        <a href="#" class="btn btn-sm header-btn">
            <i class="fa fa-facebook"></i>
            <span>Facebook</span>
        </a>
        <a href="#" class="btn btn-sm header-btn">
            <i class="fa fa-telegram"></i>
            <span>Telegram</span>
        </a>
    </div>
    <div class="header-block header-block-nav">
        <ul class="nav-profile">
            <!-- <li class="notifications new">
                <a href="" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <sup>
                        <span class="counter">8</span>
                    </sup>
                </a>
                <div class="dropdown-menu notifications-dropdown-menu">
                    <ul class="notifications-container">
                        <li>
                            <a href="" class="notification-item">
                                <div class="img-col">
                                    <div class="img" style="background-image: url('assets/faces/3.jpg')"></div>
                                </div>
                                <div class="body-col">
                                    <p>
                                        <span class="accent">Zack Alien</span> pushed new commit:
                                        <span class="accent">Fix page load performance issue</span>. </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="" class="notification-item">
                                <div class="img-col">
                                    <div class="img" style="background-image: url('assets/faces/5.jpg')"></div>
                                </div>
                                <div class="body-col">
                                    <p>
                                        <span class="accent">Amaya Hatsumi</span> started new task:
                                        <span class="accent">Dashboard UI design.</span>. </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="" class="notification-item">
                                <div class="img-col">
                                    <div class="img" style="background-image: url('assets/faces/8.jpg')"></div>
                                </div>
                                <div class="body-col">
                                    <p>
                                        <span class="accent">Andy Nouman</span> deployed new version of
                                        <span class="accent">NodeJS REST Api V3</span>
                                    </p>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <footer>
                        <ul>
                            <li>
                                <a href=""> View All </a>
                            </li>
                        </ul>
                    </footer>
                </div>
            </li> -->
            <li class="profile dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                    <div class="img" style="background-image: url(<?=$user->icon?>)"> </div>
                    <span class="name"> <?=$user->firstname?> <?=$user->lastname?> </span>
                </a>
                <div class="dropdown-menu profile-dropdown-menu">
                    <a class="dropdown-item" href="<?=$profileUrl?>">
                        <i class="fa fa-user icon"></i> <?=$this->t('profile', 'front')?>
                    </a>
                    <!-- <a class="dropdown-item" href="#">
                        <i class="fa fa-bell icon"></i> Notifications </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-gear icon"></i> Settings </a> -->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?=$logoutUrl?>">
                        <i class="fa fa-power-off icon text-danger"></i> <?=$this->t('logout', 'front')?>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</header>

