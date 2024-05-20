function toggleDeliveryNote(id, value, url) {
  var div = document.getElementById(`deliveryNote-${id}`);

  if (div.getAttribute("toggleDiv") == "true") {
    div.innerText = "";
    var textarea = document.createElement("textarea");
    textarea.value = value;
    textarea.id = `deliveryNote-textarea-${id}`;
    div.appendChild(textarea);
    textarea.focus();

    var saveButton = document.createElement("button");
    saveButton.innerText = "✔";
    saveButton.id = `deliveryNote-savebtn-${id}`;
    saveButton.addEventListener("click", function () {
      handleDeliveryNoteClick(id, textarea.value, url);
    });
    div.appendChild(saveButton);

    var closeButton = document.createElement("button");
    closeButton.innerText = "✖";
    closeButton.id = `deliveryNote-closebtn-${id}`;
    closeButton.addEventListener("click", function () {
      location.reload();
    });
    div.appendChild(closeButton);
    div.setAttribute("toggleDiv", false);
  }
}

function handleDeliveryNoteClick(id, value, url) {
  var parameters = {
    value: value,
    id: id,
  };
  new Ajax.Request(url, {
    method: "post",
    parameters: parameters,
    onSuccess: function (res) {
      document.body.innerHTML = res.responseText;
    },
  });
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
