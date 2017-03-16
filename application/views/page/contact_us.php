<div class="page-banner-area margin-bottom-80">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-banner-menu">
                    <h2 class="page-banner-title">Contact</h2>
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li>Contact</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="contact-area margin-bottom-80">
    <div class="container">
        <div class="row">

            <div class="col-md-9 col-sm-8 col-xs-12">
                <!-- Start Map area -->
                <div class="map-area">
                    <div id="googleMap" style="width:100%;height:350px;"></div>
                </div>
                <!-- End Map area -->	
                <div class="row">			
                    <!-- contact-info start -->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="contact-info">
                            <h3>Contact info</h3>
                            <ul>
                                <li>
                                    <i class="fa fa-map-marker"></i> <strong>Address:</strong>
                                    1234 Pall Mall Street, London England
                                </li>
                                <li>
                                    <i class="fa fa-envelope"></i> <strong>Phone:</strong>
                                    +8801234-123456
                                </li>
                                <li>
                                    <i class="fa fa-mobile"></i> <strong>Email:</strong>
                                    <a href="#">your-email@gmail.com</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- contact-info end -->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="contact-form">
                            <h3><i class="fa fa-envelope-o"></i> Leave a Message</h3>
                            <div class="row">
                                <form action="mail.php" method="POST">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="name" type="text" placeholder="Name (required)" />
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="email" type="email" placeholder="Email (required)" />
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input name="subject" type="text" placeholder="Subject" />
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <textarea name="message" id="message" cols="30" rows="10" placeholder="Message"></textarea>
                                        <input type="submit" value="Submit Form" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>						
            </div>
        </div>
    </div>
</div>
<!-- CONTACT-AREA END -->
<!-- BRAND-LOGO-AREA START -->

<!-- BRAND-LOGO-AREA END -->
</section>
<!-- PAGE-CONTENT END -->
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script>
    function initialize() {
        var mapOptions = {
            zoom: 5,
            scrollwheel: false,
            center: new google.maps.LatLng(40.7058316, -74.2581978)
        };

        var map = new google.maps.Map(document.getElementById('googleMap'),
                mapOptions);

        var marker = new google.maps.Marker({
            position: map.getCenter(),
            animation: google.maps.Animation.BOUNCE,
            icon: 'img/map-marker.png',
            map: map
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>


