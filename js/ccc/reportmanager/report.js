document.addEventListener("DOMContentLoaded", {});

varienGrid.prototype.saveReport = function () {
  var filters = $$(
    "#" + this.containerId + " .filter input",
    "#" + this.containerId + " .filter select"
  );
  var elements = [];
  for (var i in filters) {
    if (filters[i].value && filters[i].value.length) elements.push(filters[i]);
  }
  var saveReportData = {};

  elements.forEach((ele) => {
    saveReportData[ele.id] = ele.value;
  });

  saveReportData["report_type"] =
    this.containerId == "productGrid" ? "product" : "customer";

  new Ajax.Request(
    "http://127.0.0.1/magento/index.php/admin/reportmanager/save",
    {
      method: "post",
      parameters: saveReportData,
      onSuccess: function (response) {
        document.body.innerHTML = response.responseText;
      },
      onFailure: function () {
        alert("Failed to save data.");
      },
    }
  );
};
