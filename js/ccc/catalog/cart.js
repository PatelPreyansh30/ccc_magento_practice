$j(document).ready(function () {
  if ($j("body.checkout-cart-index").length) {
    $j('select[name^="cart"]').change(function () {
      $j(this).siblings("button").fadeIn();
    });
  }
});
