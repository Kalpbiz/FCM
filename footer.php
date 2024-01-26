<?php if(strpos($_SERVER["PHP_SELF"], basename(__FILE__)) !== false) { http_response_code(404); header('Location: https://pushsnet.com/404.php'); die(); } ?>

                </div>
                <!-- // END drawer-layout__content -->

                <div class="mdk-drawer  js-mdk-drawer" id="default-drawer" data-align="start">
                    <div class="mdk-drawer__content">
                        <div class="sidebar sidebar-light sidebar-left simplebar" data-simplebar>
                            <div class="d-flex align-items-center sidebar-p-a border-bottom sidebar-account">
                                <a href="profile.php" class="flex d-flex align-items-center text-underline-0 text-body">
                                    <span class="avatar mr-3">
                                        <img src="assets/images/avatar/demi.png" alt="avatar" class="avatar-img rounded-circle">
                                    </span>
                                    <span class="flex d-flex flex-column">
                                        <strong><?php echo ucwords($name); ?></strong>
                                        <small class="text-muted text-uppercase">Account Owner</small>
                                    </span>
                                </a>
                                <div class="dropdown ml-auto">
                                    <a href="#" data-toggle="dropdown" data-caret="false" class="text-muted"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-item-text dropdown-item-text--lh">
                                            <div><strong><?php echo ucwords($name); ?></strong></div>
                                            <div>@<?php echo $myusername; ?></div>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item <?php if($pg == 'dashboard'){echo 'active';} ?>" href="dashboard.php">Dashboard</a>
                                        <a class="dropdown-item <?php if($pg == 'profile'){echo 'active';} ?>" href="profile.php">My profile</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="logout.php">Logout</a>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="sidebar-heading sidebar-m-t">Main Menu</div>
                            <ul class="sidebar-menu">
                                
                                <li class="sidebar-menu-item <?php if($pg == 'dashboard'){echo 'active';} ?>">
                                        <a class="sidebar-menu-button" href="dashboard.php">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">dashboard</i>
                                            <span class="sidebar-menu-text">Dashboard</span>
                                        </a>
                                </li>
                                
                                
                            </ul>
                            
                            
                            <div class="sidebar-heading sidebar-m-t">Tools</div>
                            <ul class="sidebar-menu">
                        
                               
                                <li class="sidebar-menu-item">
                                
                                    <a class="sidebar-menu-button " data-toggle="collapse" href="#notification">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">settings_input_component</i>
                                        <span class="sidebar-menu-text">Notification</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>
                                    <ul class="sidebar-submenu collapse" id="notification">
                                        <li id="send-notification" class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="send-notification.php">
                                                <span class="sidebar-menu-text">Send Notification</span>
                                            </a>
                                        </li>
                                         <li id="view-history" class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="view-history.php">
                                                <span class="sidebar-menu-text">View History</span>
                                            </a>
                                        </li>
                                        
                                    </ul>
                                    
                                </li>
                                
                                
                                
                                
                                
                                
                                <li class="sidebar-menu-item">
                                
                                    <a class="sidebar-menu-button" data-toggle="collapse" href="#domain">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">settings_input_component</i>
                                        <span class="sidebar-menu-text">Domains</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>
                                    <ul class="sidebar-submenu collapse" id="domain">
                                        <li id="add-notification" class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="add-domain.php">
                                                <span class="sidebar-menu-text">Add Domain</span>
                                            </a>
                                        </li>
                                       
                                        
                                    </ul>
                                    
                                </li>
                                
                                <li class="sidebar-menu-item">
                                
                                    <a class="sidebar-menu-button" data-toggle="collapse" href="#tokens">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">settings_input_component</i>
                                        <span class="sidebar-menu-text">Tokens</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>
                                    <ul class="sidebar-submenu collapse" id="tokens">
                                        <li id="add-notification" class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="view-tokens.php">
                                                <span class="sidebar-menu-text">View Tokens Count</span>
                                            </a>
                                        </li>
                                        
                                    </ul>
                                    
                                </li>
                                
                            </ul>
                            
                            <div class="sidebar-heading">Extra Tools</div>
                            <div class="sidebar-block p-0">
                                <ul class="sidebar-menu" id="components_menu">
                                    <li class="sidebar-menu-item <?php if($pg == 'profile'){echo 'active';} ?>">
                                        <a class="sidebar-menu-button" href="profile.php">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">last_page</i>
                                            <span class="sidebar-menu-text">Profile</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="logout.php">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">location_on</i>
                                            <span class="sidebar-menu-text">Logout</span>
                                        </a>
                                    </li>
                                </ul>

                                
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- // END drawer-layout -->

        </div>
        <!-- // END header-layout__content -->

    </div>
    <!-- // END header-layout -->

    <!-- jQuery -->
    <script src="assets/vendor/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/vendor/popper.min.js"></script>
    <script src="assets/vendor/bootstrap.min.js"></script>

    <!-- Simplebar -->
    <script src="assets/vendor/simplebar.min.js"></script>

    <!-- DOM Factory -->
    <script src="assets/vendor/dom-factory.js"></script>

    <!-- MDK -->
    <script src="assets/vendor/material-design-kit.js"></script>

    <!-- App -->
    <script src="assets/js/toggle-check-all.js"></script>
    <script src="assets/js/check-selected-row.js"></script>
    <script src="assets/js/dropdown.js"></script>
    <script src="assets/js/sidebar-mini.js"></script>
    <script src="assets/js/app.js"></script>

    <!-- App Settings (safe to remove) -->
    <script src="assets/js/app-settings.js"></script>



    <!-- Flatpickr -->
    <script src="assets/vendor/flatpickr/flatpickr.min.js"></script>
    <script src="assets/js/flatpickr.js"></script>

    <!-- Global Settings -->
    <script src="assets/js/settings.js"></script>

    <!-- Chart.js -->
    <script src="assets/vendor/Chart.min.js"></script>

    <!-- App Charts JS -->
    <script src="assets/js/charts.js"></script>

    <!-- Chart Samples -->
    <script src="assets/js/page.dashboard.js"></script>

    <!-- Vector Maps -->
    <script src="assets/vendor/jqvmap/jquery.vmap.min.js"></script>
    <script src="assets/vendor/jqvmap/maps/jquery.vmap.world.js"></script>
    <script src="assets/js/vector-maps.js"></script>
</body>

</html>