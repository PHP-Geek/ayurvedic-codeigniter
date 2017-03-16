<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img class="img-circle" src="<?php
                if ($_SESSION['user']['user_profile_image'] !== '' && file_exists(FCPATH . 'uploads/users/profiles' . date('/Y/m/d/H/i/s/', strtotime($_SESSION['user']['user_created'])) . $_SESSION['user']['user_profile_image'])) {
                    echo base_url() . 'uploads/users/profiles' . date('/Y/m/d/H/i/s/', strtotime($_SESSION['user']['user_created'])) . $_SESSION['user']['user_profile_image'];
                } else {
                    echo base_url() . 'assets/img/profile.png';
                }
                ?>" class="user-image" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?php echo $_SESSION['user']['user_name']; ?></p>
                <a href="javascript:;" id="online_status"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li <?php
            if ($this->router->class === 'dashboard' && $this->router->method === 'index') {
                echo 'class="active"';
            }
            ?>><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li <?php
            if ($this->router->class === 'inventory' && in_array($this->router->method, array('index', 'add','edit'))) {
                echo 'class="active"';
            }
            ?>><a href="<?php echo base_url(); ?>inventory"><i class="fa fa-file-o"></i> <span>Inventory</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li <?php
                    if ($this->router->class === 'inventory' && $this->router->method === 'index') {
                        echo 'class="active"';
                    }
                    ?>><a href="<?php echo base_url(); ?>inventory"><i class="fa fa-th"></i> Inventory Listing</a></li>
                    <li <?php
                    if ($this->router->class === 'inventory' && $this->router->method === 'add') {
                        echo 'class="active"';
                    }
                    ?>><a href="<?php echo base_url(); ?>inventory/add"><i class="fa fa-plus"></i> Add Inventory Product</a></li>
                </ul>
            </li>
             <li <?php
            if ($this->router->class === 'configuration' && in_array($this->router->method, array('product','category','add_product','edit_category'))) {
                echo 'class="active"';
            }
            ?>><a href="javascript"><i class="fa fa-file-o"></i> <span>Configuration</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li <?php
                    if ($this->router->class === 'configuration' && $this->router->method === 'category') {
                        echo 'class="active"';
                    }
                    ?>><a href="<?php echo base_url(); ?>configuration/category"><i class="fa fa-bars"></i> Categories </a></li>                 
                    <li <?php
                    if ($this->router->class === 'configuration' && $this->router->method === 'product') {
                        echo 'class="active"';
                    }
                    ?>><a href="<?php echo base_url(); ?>configuration/product"><i class="fa fa-bookmark"></i> Products</a></li>                    
                </ul>
            </li>

        </ul>
    </section>
</aside>