<footer id="footer" class="footer-area">
    <div class="footer-widget">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="footer-link">
                        <h6 class="footer-title">{{ __('messages.footer.company') }}</h6>
                        <ul>
                            <li><a href="{{ route('about') }}">{{ __('messages.footer.about') }}</a></li>
                            <li><a href="{{ route('contact') }}">{{ __('messages.footer.contact') }}</a></li>
                            <li><a href="{{ route('career') }}">{{ __('messages.footer.career') }}</a></li>
                            <li><a href="{{ route('blog') }}">{{ __('messages.footer.blog') }}</a></li>
                        </ul>
                    </div> <!-- footer link -->
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="footer-link">
                        <h6 class="footer-title">{{ __('messages.footer.our_product') }} </h6>
                        <ul>
                            <li><a
                                    href="{{ route('ProductSparePart') }}">{{ __('messages.footer.products_sparepart') }}</a>
                            </li>
                            <li><a href="{{ route('workshop.show') }}">{{ __('messages.footer.workshop') }}</a></li>
                            <li><a href="{{ route('event.show') }}">{{ __('messages.footer.event') }}</a></li>
                        </ul>
                    </div> <!-- footer link -->
                </div>
                <div class="col-lg-3 col-md-4 col-sm-5">
                    <div class="footer-link">
                        <h6 class="footer-title">{{ __('messages.footer.help_support') }}</h6>
                        <ul>
                            <li><a href="{{ route('support-center') }}">{{ __('messages.footer.support_center') }}</a>
                            </li>
                            <li><a href="{{ route('terms') }}">{{ __('messages.footer.terms') }}</a></li>
                        </ul>
                    </div> <!-- footer link -->
                </div>
                <div class="col-lg-4 col-md-6 col-sm-7">
                    <div class="footer-link">
                        <h6 class="footer-title">{{ __('messages.footer.our_social_media') }}</h6>
                        <ul>
                            <li><a href="#"><i class="bx bxl-facebook-square"></i> Facebook</a></li>
                            <li><a href="#"><i class="bx bxl-instagram-alt"></i> Instagram</a></li>
                            <li><a href="#"><i class="bx bxl-twitter"></i> Twitter</a></li>
                            <li><a href="#"><i class="bx bxl-linkedin"></i> LinkedIn</a></li>
                            <li><a href="#"><i class="bx bxs-info-circle"></i> Info</a></li>
                        </ul>
                    </div> <!-- footer newsletter -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </div> <!-- footer widget -->
    <div class="footer-copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright text-center">
                        <p class="text">
                            Copyright &copy; {{ now()->year }} eBengkelku - Service, Spare Part & Smart Tools
                            Powered By <a href="https://cnplus.id/" target="_blank"
                                class="link-cnplus text-decoration-none fw-semibold">CNPLUS</a>
                        </p>
                    </div>
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </div> <!-- footer copyright -->
</footer>
