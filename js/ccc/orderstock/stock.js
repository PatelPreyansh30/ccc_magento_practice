function handleStockChange(value, id) {
  var stockSelect = document.getElementById("stock");
  var calendarDiv = document.getElementById("calendar");
  var datePicker = document.getElementById("datepicker_" + id);
  if (value === "backordered-" + id) {
    datePicker.style.display = "block";
    $(function () {
      $("#datepicker_" + id).datepicker({
        dateFormat: "yy-mm-dd",
        onSelect: function (dateText) {
          var selectedDate = dateText;
        },
      });
    });
  } else {
    datePicker.style.display = "none";
  }
}
var itemElements = Array.from(document.querySelectorAll('[id^="itemid"]'));
const dateInput = document.getElementById("datepicker_");

dateInput.addEventListener("input", function () {
  const inputValue = this.value;
  if (/^\d{4}-\d{2}-\d{2}$/.test(inputValue)) {
    const currentDate = new Date();
    const enteredDate = new Date(inputValue);
    if (enteredDate < currentDate) {
      alert("Please select today's date or a future date.");
      const today = currentDate.toISOString().slice(0, 10);
      this.value = today;
    } else {
      const previousDate = new Date(
        enteredDate.getTime() - 24 * 60 * 60 * 1000
      );
      const previousDateString = previousDate.toISOString().slice(0, 10);
      $(this).datepicker("setDate", previousDateString);
    }
  }
});

function updatestock() {
  var items = [];
  var itemElements = Array.from(document.querySelectorAll('[id^="itemid"]'));

  itemElements.forEach(function (itemElement) {
    var itemValue = itemElement.value;
    var selectElement = document.getElementById("stock-" + itemValue);
    var selectedValue = selectElement.value;
    if (selectedValue == "instock-" + itemValue) {
      const currentDate = new Date();
      const year = currentDate.getFullYear();
      const month = String(currentDate.getMonth() + 1).padStart(2, "0");
      const day = String(currentDate.getDate()).padStart(2, "0");
      const currentDateString = `${year}-${month}-${day}`;
      selectedValue = currentDateString;
    }
    if (selectedValue == "discontinued-" + itemValue) {
      selectedValue = 1;
    }
    if (selectedValue == "backordered-" + itemValue) {
      selectedValue = document.getElementById("datepicker_" + itemValue).value;
    }
    items.push({
      id: itemValue,
      stock: selectedValue,
    });
  });
  var itemData = JSON.stringify(items);
  var url = "http://127.0.0.1/magento/index.php/admin/orderstock/update";
  url += "/key/" + FORM_KEY;
  var parameters = {
    value: itemData,
  };
  new Ajax.Request(url, {
    method: "post",
    parameters: parameters,
  });
}

function mailhandle() {
  var id = [];
  var itemElements = Array.from(document.querySelectorAll('[id^="itemid"]'));
  itemElements.forEach(function (itemElement) {
    var itemValue = itemElement.value;
    id.push(itemValue);
  });
  var jsonData = JSON.stringify(id);

  new Ajax.Request(mailUrl, {
    method: "post",
    parameters: {
      data: jsonData,
      form_key: FORM_KEY,
    },
  });
}
