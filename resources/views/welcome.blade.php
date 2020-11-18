<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Slingtheworld</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="img/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <!-- <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" /> -->
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="/css/welcome-page/styles.css" rel="stylesheet" />
        <link href="/css/flexslider.css" rel="stylesheet" />
        <link rel='stylesheet' id='parallel-slick-css'  href='/css/welcome-page/slickfe9d.css?ver=4.7.3' type='text/css' media='all' />
        <link rel='stylesheet' id='parallel-slick-theme-css'  href='/css/welcome-page/slick-themefe9d.css?ver=4.7.3' type='text/css' media='all' />
        <link rel='stylesheet' id='parallel-slick-theme-css'  href='/css/welcome-page/font-awesome.minfe9d.css?ver=4.7.3' type='text/css' media='all' />
        <!-- <link rel='stylesheet' id='parallel-bootstrap-css'  href='/css/welcome-page/bootstrap.minfe9d.css' type='text/css' media='all' /> -->
        <link rel='stylesheet' href='/css/welcome-page/bootstrap.min.css' type='text/css' media='all' />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
            <div class="container">
                <!-- <a class="navbar-brand js-scroll-trigger" href="#page-top">SLING</a> -->
                <h1 class="site-title"><a href="#" title="// Parallel" rel="home"><img style="width: 132px;" src="/img/welcome-page/sling-logo-gray.png"> </a></h1>
                <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto pull-right">
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#how-it-works">How It Works</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">About Us</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#giving-back">Giving Back</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">Contact</a></li>
                        <li class="nav-item mx-0 mx-lg-1">
                            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="{{ route('register') }}">Sign Up</a>
                            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                              Launch demo modal
                            </button> -->
                        </li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="{{ route('login') }}">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead bg-primary text-white text-center">
            <div class="container">
                <div class="row">
                    <div class="col-6 text-justify">
                        <h2 class="slidertitle">Sling someone today</h2>
                        <p class="slidertext">Sling gives you the ability to share a moment with<br/>someone by buying them a drink when you can’t be in<br/>the same place.
                        <a class="ajax-popup-link text-white" href="terms.html"> <strong> Terms & Conditions  </strong> </a></p>
                        <a id="upload" href="#"><span class="button-home"><i class="fa fa-apple-alt"></i> App Store</span></a>

                        <a id="upload" href="#"><span class="button-home"><i class="fa fa-play"></i> Play Store</span></a>
                    </div>
                    <div class="col-6">

                        <img src="/img/welcome-page/iphone-2.png" class="attachment-full size-full slide-first-img" alt="" title="" sizes="(max-width: 504px) 100vw, 504px" draggable="false" width="450" height="500">
                    </div>
                </div>
            </div>
        </header>
        <!-- Portfolio Section-->
        <section class="page-section portfolio" id="how-it-works">
            <div class="container">
                <!-- Portfolio Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">How it works</h2>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <p class="subtitle text-center">The Sling platform lets you replicate the age-old tradition of buying someone a drink - when you can’t be in the same place!
                </p>
                <!-- Portfolio Grid Items-->
                <div class="row">
                    <!-- Portfolio Item 1-->
                    <div class="col-md-6 col-lg-4 mb-5">
                            <iframe width="370" height="315" src="https://www.youtube.com/embed/Ak41BUwzyzM" frameborder="0" gesture="media" allowfullscreen></iframe>
                    </div>
                    <!-- Portfolio Item 2-->
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="portfolio-item mx-auto" data-toggle="modal" data-target="#portfolioModal2">
                            <h3 class="widget-title" style="text-align:center"><strong>How Sling works</strong></h3>
                            <div class="details">
                                    <p>
                                        Choose: 
                                        <span>
                                            a friend you would like to Sling a drink to – from within the app, from your Facebook friends or from your phone contacts
                                        </span>
                                    </p>
                                    <p>Select: 
                                        <span>
                                            the venue you want to Sling from.
                                        </span>
                                    </p>
                                    <p>
                                        Pick: 
                                        <span>
                                            from the list of drinks and <strong>Voila!</strong> Your friend receives a notification and Sling QR code and the bartender hands over their drink!
                                        </span>
                                    </p>
                                    <p><a class="ajax-popup-link" href="faq-QA.html">FAQs &#8594;</a></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 col-lg-4 project-gallery slider">
                        <div><img src="/img/welcome-page/slide1.png" class="img-fluid center-block" alt=""></div>
                        <div><img src="/img/welcome-page/slide2.png" class="img-fluid center-block" alt=""></div>
                        <div><img src="/img/welcome-page/slide3.png" class="img-fluid center-block" alt=""></div>
                    </div>
                </div>
            </div>

        </section>
        <!-- About Section-->
        <section class="page-section bg-primary text-white mb-0" id="about">
            <div class="container">
                <!-- About Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-white">About Us</h2>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <!-- About Section Content-->
                <div class="row">
                    <div class="col-lg-6 ml-auto"><p class="lead">The Sling team is made up of a group of friends who live in different cities around the world and probably like many others, found it impossible to buy a friend a drink because they were not in the same place.</p></div>
                    <div class="col-lg-6 mr-auto"><p class="lead">Sling uses technology to support the age-old tradition of buying someone a drink, when not in the same place. Allowing anyone, anywhere, anytime to buy a drink for a friend from carefully curated establishments.</p></div>

                    <div class="col-lg-6 mr-auto"><p class="lead">Distance is no longer an obstacle when you want to buy a friend a drink. Sling lets you virtually share a moment with a friend. The app lets you buy them drink, all while supporting local businesses.</p></div>

                    <div class="col-lg-6 mr-auto"><p class="lead">It’s not a gift voucher. Sling embodies the personal nature of actually buying a friend a drink, sharing in the experience and joy.</p></div>
                </div>
               
            </div>
        </section>
        <!-- Giving Back Section-->
        <section class="page-section bg-secondary text-white mb-0" id="giving-back">
            <div class="container">
                <!-- About Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-white">Giving Back</h2>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <p class="lead text-center">Everyone can make a difference. However small, it all adds up. With Sling, <strong> YOU </strong> are making a difference!</p>
                <!-- About Section Content-->
                <div class="row">
                    <div class="col-lg-6 ml-auto">
                        <p class="lead">
                            Sling is dedicated to giving back, supporting underprivileged children though education, nourishment and shelter. Sling believes that education is the key to a better life. Education opens doors and opportunities. Opportunities that otherwise would not arise.
                        </p>
                        <p class="lead">
                            In practical terms, a portion of all profits go towards carefully selected local organisations that partner with Sling to provide educational opportunities, a safe environment to live and a nutritious, balanced diet, to children all over the world.
                        </p>

                    </div>

                    <div class="col-lg-6 mr-auto">
                        <img class="img-fluid" src="/img/welcome-page/books-2383396_1920.jpg">
                    </div>
                </div>
               
            </div>
        </section>
        <!-- Contact Section-->
        <section class="page-section" id="contact">
            <div class="container">
                <!-- Contact Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Contact Us</h2>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <!-- Contact Section Form-->
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19.-->
                        <form id="contactForm" name="sentMessage" novalidate="novalidate">
                            <div class="control-group">
                                <div class="form-group floating-label-form-group controls mb-0 pb-2">
                                    <label>Name</label>
                                    <input class="form-control" id="name" type="text" placeholder="Name" required="required" data-validation-required-message="Please enter your name." />
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="form-group floating-label-form-group controls mb-0 pb-2">
                                    <label>Email Address</label>
                                    <input class="form-control" id="email" type="email" placeholder="Email Address" required="required" data-validation-required-message="Please enter your email address." />
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="form-group floating-label-form-group controls mb-0 pb-2">
                                    <label>Phone Number</label>
                                    <input class="form-control" id="phone" type="tel" placeholder="Phone Number" required="required" data-validation-required-message="Please enter your phone number." />
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="form-group floating-label-form-group controls mb-0 pb-2">
                                    <label>Message</label>
                                    <textarea class="form-control" id="message" rows="5" placeholder="Message" required="required" data-validation-required-message="Please enter a message."></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <br />
                            <div id="success"></div>
                            <div class="form-group"><button class="btn btn-primary btn-xl" id="sendMessageButton" type="submit">Send</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="footer text-center">
            <div class="container">
                <div class="row">
                    <!-- Footer Location-->
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <h4 class="text-uppercase mb-4">&nbsp;</h4>
                        <p class="lead mb-0">
                            2215 John Daniel Drive
                            <br />
                            Clark, MO 65243
                        </p>
                    </div>
                    <!-- Footer Social Icons-->
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <h4 class="text-uppercase mb-4">&nbsp;</h4>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-linkedin-in"></i></a>
                    </div>
                    <!-- Footer About Text-->
                    <div class="col-lg-4">
                        <h4 class="text-uppercase mb-4">&nbsp;</h4>
                        <p class="lead mb-0">
                            Lorem Ipsum Dolor. Sample content here
                        </p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Copyright Section-->
        <div class="copyright py-4 text-center text-white">
            <div class="container"><small>Copyright © Sling the world {{date('Y')}}</small></div>
        </div>
        <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
        <div class="scroll-to-top d-lg-none position-fixed">
            <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Contact form JS-->
        <script src="assets/mail/jqBootstrapValidation.js"></script>
        <script src="assets/mail/contact_me.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>

        <script type='text/javascript' src='/js/welcome-page/slick.minaff7.js?ver=1.6.0'></script>
        <script type='text/javascript' src='/js/welcome-page/bootstrap.min.js'></script>
        <script type="text/javascript">
            
        $(".project-gallery").slick({
            dots: true,
            autoplay: true,
            autoplaySpeed: parseInt(7)*1000,
            arrows: false,
            pauseOnHover: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            responsive: [{
                breakpoint: 979,
                settings: {
                    slidesToShow: 1,
                }
            }, {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                }
            }]
        });
        </script>
    </body>
</html>
