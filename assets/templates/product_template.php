<div class="breadcrumbs">
  <div class="container">
    <a href="/index.php">Melissa</a> > <?php echo $t_product_name; ?> Drawing
  </div>
</div>
<div class="product_page">
  <div class="container">
    <div class="sides">
      <div class="left">
	   <div class="gradient-border" style="margin-top:0;">
        <div class="product_box"  style="background-image:url('<?php echo $t_product_image; ?>')">
		</div>
          <span class="product_code" style="display:none;"><?php echo $t_product_form_name; ?></span>
          <!-- <div class="hover_box">
            <div class="paragraph">
              <?php echo $t_product_hover_text; ?>
            </div>
            <div class="sales">
              <?php echo $t_product_sales; ?>+ sales
              <div class="rating">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
              </div>
            </div>
          </div> -->
        </div>
      </div>
      <div class="right">
	   <div class="gradient-border" style="margin-top:0;">
	  <div class="product-purchase">
        <h1><?php echo $t_product_title; ?></h1>
        <!--<span class="bestseller">Bestseller</span>-->
        <div class="price_box">
          <span class="new_prce">$29.99</span>
          <span class="old_price"><del>$299.90<del></span>

        </div>
        <span class="saved"> <strong>You save <span class="saveda">$270 (90%)</p></strong> </span>
        <h2>Sale ends in few hours</h2>
          <!--<span class="vat"> <strong>VAT included (where applicable)</strong> </span>-->

          <?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/order-form.php'; ?>
          <!-- <div class="disclamer">
            I will use my Psychic Abilities to draw your <?php echo $t_product_name; ?> within 48 hours with 100% accuracy, All i need is your full name and birth date!
          </div> -->
      </div>
	  </div>
	  </div>
    </div>
    <!-- <div class="icons_product">
      <div class="sides">
        <div class="third">
          <i class="fas fa-user-shield"></i>
          <h3>Secure Purchase</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sollicitudin lacus et augue ullamcorper consequat. Sed egestas quam a aliquet congue.</p>
        </div>
        <div class="third">
          <i class="fas fa-cart-plus"></i>
          <h3>In High Demand</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sollicitudin lacus et augue ullamcorper consequat. Sed egestas quam a aliquet congue.</p>
        </div>
        <div class="third">
          <i class="fas fa-truck-moving"></i>
          <h3>3 Delivery Options</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sollicitudin lacus et augue ullamcorper consequat. Sed egestas quam a aliquet congue.</p>
        </div>
      </div>

    </div> -->
  </div>
</div>
<div class="container">
<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/review-total.php'; ?>
</div>

<div class="container">
 <div class="gradient-border">
  <div class="product_text">
    <h2><?php echo $t_about_title; ?></h2>
    <?php echo $t_about_content; ?>
  </div>
 </div>
</div>
<!-- <div class="product_description">
  <div class="container">
    <h2><?php echo $t_about_title; ?></h2>
    <?php echo $t_about_content; ?>
  </div>
</div> -->
<section class="reviews">
  <div class="container">
    <h2>But dont take my word, here is what my past clients say:</h2>
      <?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/reviews.php'; ?>
  </div>
</section>
<script>
jQuery('input[name="priority"]').change(function(){
    if (this.value == '12') {
        jQuery('.new_prce').animate({'opacity' : 0}, 200, function(){jQuery('.new_prce').html('$49.99').animate({'opacity': 1}, 200);});
		jQuery('.old_price del').animate({'opacity' : 0}, 300, function(){jQuery('.old_price del').html('$499.99').animate({'opacity': 1}, 300);});
		jQuery('.saveda').animate({'opacity' : 0}, 400, function(){jQuery('.saveda').html('$450 (90%)').animate({'opacity': 1}, 400);});	
    }
    if (this.value == '24') {
		jQuery('.new_prce').animate({'opacity' : 0}, 200, function(){jQuery('.new_prce').html('$39.99').animate({'opacity': 1}, 200);});
		jQuery('.old_price del').animate({'opacity' : 0}, 300, function(){jQuery('.old_price del').html('$399.99').animate({'opacity': 1}, 300);});
		jQuery('.saveda').animate({'opacity' : 0}, 400, function(){jQuery('.saveda').html('$360 (90%)').animate({'opacity': 1}, 400);});
    }
    if (this.value == '48') {
		jQuery('.new_prce').animate({'opacity' : 0}, 200, function(){jQuery('.new_prce').html('$29.99').animate({'opacity': 1}, 200);});
		jQuery('.old_price del').animate({'opacity' : 0}, 300, function(){jQuery('.old_price del').html('$299.99').animate({'opacity': 1}, 300);});
		jQuery('.saveda').animate({'opacity' : 0}, 400, function(){jQuery('.saveda').html('$270 (90%)').animate({'opacity': 1}, 400);});
    }
})
</script>
