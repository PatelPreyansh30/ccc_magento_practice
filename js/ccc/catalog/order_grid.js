function submitTextarea(textareaId) {
  event.preventDefault();
  event.stopPropagation();
  var textarea = document.getElementById(textareaId);
  var url = "http://127.0.0.1/magento/index.php/admin/sales_order/edit";
  url += "/key/" + FORM_KEY;

  var parameters = {
    delivery_note: textarea.value,
    entity_id: textareaId.split("_")[2],
  };
  new Ajax.Request(url, {
    method: "post",
    parameters: parameters,
  });
}

function resetTextarea(textareaId) {
  var textarea = document.getElementById(textareaId);
  textarea.value = "";
}

function focusTextarea(event) {
  event.preventDefault();
  event.stopPropagation();
}

function focusOrderStatusBar(id) {
  document.querySelectorAll(`#${id} .order-status`).forEach(function (span) {
    span.style.display = "block";
  });
}

function unfocusOrderStatusBar(id) {
  document.querySelectorAll(`#${id} .order-status`).forEach(function (span) {
    span.style.display = "none";
  });
}

function getDropdownText(totalRange, status) {
  let range = totalRange.split("-");
  var url = "http://127.0.0.1/magento/index.php/admin/sales_order/index";
  url += "/key/" + FORM_KEY;
  var parameters = {
    start: range[0],
    end: range[1],
    status: status,
  };
  new Ajax.Request(url, {
    method: "post",
    parameters: parameters,
    onSuccess: function (response) {
      document.body.innerHTML = response.responseText;
    },
  });
}
