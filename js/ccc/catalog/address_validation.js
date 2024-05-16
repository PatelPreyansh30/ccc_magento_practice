function addressValidate(incrementId, url) {
  new Ajax.Request(url, {
    method: "post",
    parameters: {
      order_id: incrementId,
      form_key: FORM_KEY,
    },
    onSuccess: function (response) {
        window.location.reload();
    },
  });
}
