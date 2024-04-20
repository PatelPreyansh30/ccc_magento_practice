Review.prototype.save = function () {
  if (checkout.loadWaiting != false) return;
  checkout.setLoadWaiting("review");

  var params = Form.serialize(payment.form);
  if (this.agreementsForm) {
    params += "&" + Form.serialize(this.agreementsForm);
  }

  var deliveryNote = $("delivery_note").value;
  params += "&delivery_note=" + encodeURIComponent(deliveryNote);

  new Ajax.Request(this.saveUrl, {
    method: "post",
    parameters: params,
    onComplete: this.onComplete,
    onSuccess: this.onSave,
    onFailure: checkout.ajaxFailure.bind(checkout),
  });
};
