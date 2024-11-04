<footer id="footer" class="footer-area">
  <div class="footer-widget">
    <div class="container">
      <div class="row">
        <div class="col-lg-2 col-md-4 col-sm-6">
          <div class="footer-link">
            <h6 class="footer-title">Company</h6>
            <ul>
              <li><a href="{{ route('about') }}">About</a></li>
              <li><a href="{{ route('contact') }}">Contact</a></li>
              <li><a href="#">Career</a></li>
            </ul>
          </div> <!-- footer link -->
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="footer-link">
            <h6 class="footer-title">Our Product</h6>
            <ul>
              <li><a href="{{ route('ProductSparePart') }}">Products & Sparepart</a></li>
              <li><a href="{{ route('workshop.show') }}">Workshop</a></li>
              <li><a href="{{ route('event.show') }}">Event</a></li>
            </ul>
          </div> <!-- footer link -->
        </div>
        <div class="col-lg-3 col-md-4 col-sm-5">
          <div class="footer-link">
            <h6 class="footer-title">Help & Support</h6>
            <ul>
              <li><a href="{{ route('support-center') }}">Support Center</a></li>
              <li><a href="{{ route('faqs') }}">FAQs</a></li>
              <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
            </ul>
          </div> <!-- footer link -->
        </div>
        <div class="col-lg-4 col-md-6 col-sm-7">
          <div class="footer-link">
            <h6 class="footer-title">Our Social Media</h6>
            <ul>
              <li><a href="#"><i class="bx bxl-facebook-square"></i> Facebook</a></li>
              <li><a href="#"><i class="bx bxl-instagram-alt"></i> Instagram</a></li>
              <li><a href="#"><i class="bx bxl-twitter"></i> Twitter</a></li>
              <li><a href="#"><i class="bx bxl-linkedin"></i> LinkedIn</a></li>
              <li>
                <a href="#">
                  <i class="bx bxs-info-circle"></i> Info</a>
                </a>
              </li>
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
              Powered By <a href="https://cnplus.id/" target="_blank" class="text-success">CNPLUS</a>
            </p>
          </div>
        </div>
      </div> <!-- row -->
    </div> <!-- container -->
  </div> <!-- footer copyright -->
</footer>
