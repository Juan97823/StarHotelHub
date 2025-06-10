<?php include_once 'views/template/header-principal.php'; ?>
<?php include_once 'views/template/portada.php'; ?>

<!-- Start Sign Up Area -->
<section class="user-area-all-style sign-up-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="contact-form-action">
                    <div class="form-heading text-center">
                        <h3 class="form-title">Create an account!</h3>
                        <p class="form-desc">With your social network.</p>
                    </div>
                    <form method="post">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <button class="default-btn" type="submit">
                                    Google
                                    <i class="bx bxl-google"></i>
                                </button>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="name" placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 ">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="name" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="name" placeholder="Enter your username">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <input class="form-control" type="email" name="email" placeholder="Email Address">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 ">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="password" placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-condition">
                                <div class="agree-label">
                                    <input type="checkbox" id="chb1">
                                    <label for="chb1">
                                        I agree with Haipe's
                                        <a href="#">Privacy Policy</a>
                                    </label>
                                </div>
                                <div class="agree-label">
                                    <input type="checkbox" id="chb2">
                                    <label for="chb2">
                                        I agree with Haipe's
                                        <a href="#">Terms of Services</a>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="default-btn btn-two" type="submit">
                                    Register Account
                                    <i class="flaticon-right"></i>
                                </button>
                            </div>
                            <div class="col-12">
                                <p class="account-desc">
                                    Already have an account?
                                    <a href="log-in.html"> Login</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Sign Up Area -->
<?php include_once 'views/template/footer-principal.php'; ?>

<script src="<?php echo RUTA_PRINCIPAL . 'assets/principal/js/pages/registro.js'; ?>"></script>
</body>

</html>