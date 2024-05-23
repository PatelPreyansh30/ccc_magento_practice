document.addEventListener("DOMContentLoaded", () => {
  if (typeof customerGridJsObject != "undefined") {
    customerGridJsObject.loadFilter();
  }
  if (typeof productGridJsObject != "undefined") {
    productGridJsObject.loadFilter();
  }
});

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

varienGrid.prototype.loadFilter = function () {
  var productFilter, customerFilter;
  new Ajax.Request(
    "http://127.0.0.1/magento/index.php/admin/reportmanager/loadFilter",
    {
      method: "post",
      asynchronous: false,
      onSuccess: function (response) {
        JSON.parse(response.responseText).forEach((ele) => {
          if (ele.report_type == "product") {
            productFilter = JSON.parse(ele.filter_data);
          } else if (ele.report_type == "customer") {
            customerFilter = JSON.parse(ele.filter_data);
          }
        });
      },
    }
  );

  let elements = [];
  if (this.containerId == "productGrid") {
    for (const key in productFilter) {
      let ele = document.getElementById(key);
      ele.value = productFilter[key];
      elements.push(ele);
    }
  } else if (this.containerId == "customerGrid") {
    for (const key in customerFilter) {
      let ele = document.getElementById(key);
      ele.value = customerFilter[key];
      elements.push(ele);
    }
  }
  if (
    !this.doFilterCallback ||
    (this.doFilterCallback && this.doFilterCallback())
  ) {
    this.reload(
      this.addVarToUrl(
        this.filterVar,
        encode_base64(Form.serializeElements(elements))
      )
    );
  }
};

function loadData(url) {
  var id = document.getElementById("admin_user").value;
  new Ajax.Request(url, {
    method: "post",
    parameters: { id: id },
    onSuccess: function (response) {
      document.body.innerHTML = response.responseText;
    },
  });
}