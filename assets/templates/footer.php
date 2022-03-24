  </main>

<?php if ($startpixel == 1) { ?>
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '<?php echo $FBPixel; ?>');
fbq('track', 'PageView');
</script>

<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=<?php echo $FBPixel; ?>&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
<?php } ?>

<?php echo $FBPurchasePixel; ?>

<?php echo $FBViewContent; ?>


    <footer>
	
      <div class="container">

      <div class="paragraph">
      The information contained herein should not be used as a substitute for the advice of appropriately qualified and licensed person. According to all laws, I must state that my services are for entertainments purposes only. I have no liability and/or responsibility for any actions and/or decisions any buyer/client chooses to take or make based on his/her consultation.
</div><hr>
        <div class="sides">
          <div class="quarter">
            <h3>From Melissa</h3>
            <div class="paragraph">
              Wouldn’t Be Great To Permanently Stop Your Problems, Even if You’ve Tried Everything Before?
            </div>
          </div>
          <div class="quarter">
            <h3>Services</h3>
            <ul>
              <li> <a href="/soulmate-drawing.php">Soulmate Drawing</a> </li>
              <li> <a href="/twin-drawing.php">Twin Flame Drawing</a> </li>
              <li> <a href="/wife-husband-drawing.php">Future Husband/Wife Drawing</a> </li>
              <li> <a href="/baby-drawing.php">Future Baby Drawing</a> </li>
              <li> <a href="/contact.php#faq">FAQ</a> </li>
            </ul>
          </div>
          <div class="quarter">
            <h3>Account</h3>
            <ul>
              <li> <a href="/dashboard.php">Dashboard</a> </li>
              <li> <a href="/privacy-policy.php">Privacy Policy</a></li>
              <li> <a href="/terms-and-conditions.php">Terms & Conditions</a> </li>
              <li> <a href="/terms-and-conditions.php#refunds">Refunds</a> </li>
              <li> <a href="/contact.php">Contact</a> </li>
            </ul>
          </div>

          <div class="quarter">
            <a href="/index.php">
              <img src="/assets/img/logo_footer.png" alt="Melissa">
            </a>
            <div class="cards">
              <img src="/assets/img/cards.png" alt="credit_cards">
            </div>
          </div>
        </div>
      </div>
      <div class="cr">
        <div class="container">
          &copy; <?php echo date("Y"); ?> Melissa. All Rights Reserved.
        </div>
      </div>
      <!-- Footer JS Files -->
      <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
      <script src="/assets/js/scripts.js"></script>
	    <script src="/assets/js/lazyload.js"></script>
    </footer>
  </body>
</html>
