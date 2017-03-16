 <!-- HEADER-AREA START -->
    <header class="header-area">
        <!-- Header-Top Start -->
        <div class="header-top hidden-xs">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="header-top-left text-left">
                            <ul>
                                <li>
                                    <i class="sp-phone"></i>
                                    <span>+019 (111) 25184203</span>
                                </li>
                                <li>
                                    <i class="sp-email"></i>
                                    <span>Company@domain.com</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="header-top-right pull-right">
                            <ul>
                                <li><a href="#">Account <span><i class="sp-gear"></i></span></a>
                                    <ul class="submenu">
                                        <li><a href="#">My Account</a></li>
                                        <!--<li><a href="#">Wishlist</a></li>-->
                                        <li><a href="#">Checkout</a></li>
                                        <li><a href="<?php echo base_url(); ?>login">Login</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="header-search">
                                <form action="#">
                                    <input type="text" placeholder="Search..." />
                                    <button type="submit"><i class="sp-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header-Top End -->
        <!-- Main-Header Start -->
        <div class="main-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-2 col-sm-6 col-xs-12">
                        <div class="logo">
                            <a href="<?php echo base_url();?>"><img src="<?php echo base_url(); ?>assets/img/logo.png" alt="" /></a>
                        </div>
                    </div>
                    <div class="col-md-8 hidden-sm hidden-xs">
                        <div class="main-menu pull-right">
                            <nav>
                                <ul>
                                    <li><a href="<?php echo base_url();?>">Home</a>
                                        <!--<ul class="submenu">
                                            <li class="submenu-title"><a href="#">Home pages</a></li>
                                            <li><a href="index.html">Homepage Version 1</a></li>
                                            <li><a href="index-2.html">Homepage Version 2</a></li>
                                        </ul>-->
                                    </li>
                                    <li><a href="<?php echo base_url(); ?>about-us">About Us</a></li>
                                    <li><a href="shop-list.html">Gallery</a></li>
                                    <li><a href="shop.html">shop</a>
                                        <div class="mega-menu">
                                            <span>
                                                <a class="mega-menu-title" href="#">WOMEN CLOTH</a>
                                                <a href="#">casual shirt</a>
                                                <a href="#">rikke t-shirt</a>
                                                <a href="#">mia top</a>
                                                <a href="#">mia top</a>
                                                <a href="#">muscle tee</a>
                                                <a href="#">seine blouse</a>
                                            </span>
                                            <span>
                                                <a class="mega-menu-title" href="#">MEN CLOTH</a>
                                                <a href="#">casual shirt</a>
                                                <a href="#">t-shirt</a>
                                                <a href="#">t-shirt</a>
                                                <a href="#">zeans</a>
                                                <a href="#">trousers/ pants </a>
                                                <a href="#">sweamwear</a>
                                            </span>
                                            <span>
                                                <a class="mega-menu-title" href="#">WOMEN JEWELRY</a>
                                                <a href="#">necklace</a>
                                                <a href="#">samhar cuff</a>
                                                <a href="#">samhar cuff</a>
                                                <a href="#">samhar cuff</a>
                                                <a href="#">nail set</a>
                                                <a href="#">drop earrings</a>
                                            </span>
                                            <span class="mega-menu-photo">
                                                <a href="#"><img src="<?php echo base_url(); ?>assets/img/megamenu/1.jpg" alt="" /></a>
                                            </span>
                                        </div>
                                    </li>
                                    <li><a href="blog.html">blog</a>
                                        <ul class="submenu">
                                            <li class="submenu-title"><a href="#">Blog pages</a></li>
                                            <li><a href="blog.html">Blog</a></li>
                                            <li><a href="single-blog.html">Single-blog</a></li>
                                        </ul>
                                    </li><!-- 
                                    <li><a href="about.html">about</a></li> -->
                                    <li><a href="#">Pages</a>
                                        <ul class="submenu">
                                            <li class="submenu-title"><a href="#">All pages</a></li>
                                            <li><a href="shop.html">Shop</a></li>
                                            <li><a href="shop-list.html">Shop-List</a></li>
                                            <li><a href="single-product.html">Single Product</a></li>
                                            <li><a href="cart.html">Shopping Cart</a></li>
                                            <li><a href="wishlist.html">Wishlist</a></li>
                                            <li><a href="checkout.html">Checkout</a></li>
                                            <li><a href="login.html">Login</a></li>
                                            <li><a href="my-account.html">My Account</a></li>
                                            <li><a href="blog.html">Blog</a></li>
                                            <li><a href="single-blog.html">Single-Blog</a></li>
                                            <li><a href="about.html">About</a></li>
                                            <li><a href="404.html">404</a></li>
                                            <li><a href="contact.html">Contact Us</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="javascript:;">Contact</a>
                                        <ul class="submenu">
                                            <li class="submenu-title"><a href="javascript:;">All pages</a></li>
                                            <li><a href="<?php echo base_url(); ?>contact-us">Contact Us</a></li>
                                            <li><a href="<?php  echo base_url();?>terms">Terms & Conditions</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                        <div class="total-cart">
                            <ul>
                                <li>
                                    <a href="#">
                                        <span class="total-cart-number">2 Item</span>
                                        <span><i class="sp-shopping-bag"></i></span>
                                    </a>
                                    <!-- Mini-cart-content Start -->
                                    <div class="total-cart-brief">
                                        <div class="cart-photo-details">
                                            <div class="cart-photo">
                                                <a href="#"><img src="<?php echo base_url(); ?>assets/img/total-cart/1.jpg" alt="" /></a>
                                            </div>
                                            <div class="cart-photo-brief">
                                                <a href="#">Men's Shirt Shirt</a>
                                                <span>$25.00</span>
                                            </div>
                                            <div class="pro-delete">
                                                <a href="#"><i class="sp-circle-close"></i></a>
                                            </div>
                                        </div>
                                        <div class="cart-photo-details">
                                            <div class="cart-photo">
                                                <a href="#"><img src="<?php echo base_url(); ?>assets/img/total-cart/1.jpg" alt="" /></a>
                                            </div>
                                            <div class="cart-photo-brief">
                                                <a href="#">Men's Shirt Shirt</a>
                                                <span>$25.00</span>
                                            </div>
                                            <div class="pro-delete">
                                                <a href="#"><i class="sp-circle-close"></i></a>
                                            </div>
                                        </div>
                                        <div class="cart-subtotal">
                                            <p>Total = $50.00</p>
                                        </div>
                                        <div class="cart-inner-btm">
                                            <a href="#">Checkout</a>
                                        </div>
                                    </div>
                                    <!-- Mini-cart-content End -->
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main-Header End -->
        <!-- Mobile-menu start -->
        <div class="mobile-menu-area hidden-md hidden-lg">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="mobile-menu">
                            <nav id="dropdown">
                                <ul>
                                    <li><a href="<?php echo base_url();?>">home</a>
                                        <ul class="submenu">
                                            <li class="submenu-title"><a href="<?php echo base_url();?>">Home pages</a></li>
                                            <li><a href="<?php echo base_url();?>">Homepage Version 1</a></li>
                                            <li><a href="index-2.html">Homepage Version 2</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="shop.html">mens</a></li>
                                    <li><a href="shop-list.html">womens</a></li>
                                    <li><a href="shop.html">shop</a></li>
                                    <li><a href="blog.html">blog</a>
                                        <ul class="submenu">
                                            <li class="submenu-title"><a href="#">Blog pages</a></li>
                                            <li><a href="blog.html">Blog</a></li>
                                            <li><a href="single-blog.html">Single-blog</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Pages</a>
                                        <ul class="submenu">
                                            <li class="submenu-title"><a href="#">All pages</a></li>
                                            <li><a href="shop.html">Shop</a></li>
                                            <li><a href="shop-list.html">Shop-List</a></li>
                                            <li><a href="single-product.html">Single Product</a></li>
                                            <li><a href="cart.html">Shopping Cart</a></li>
                                            <li><a href="wishlist.html">Wishlist</a></li>
                                            <li><a href="checkout.html">Checkout</a></li>
                                            <li><a href="login.html">Login</a></li>
                                            <li><a href="my-account.html">My Account</a></li>
                                            <li><a href="blog.html">Blog</a></li>
                                            <li><a href="single-blog.html">Single-Blog</a></li>
                                            <li><a href="about.html">About</a></li>
                                            <li><a href="contact.html">Contact Us</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="contact.html">contact</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile-menu end -->            
    </header>
    <!-- HEADER-AREA END -->