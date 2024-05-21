var editData = Class.create();
editData.prototype = {
  initialize: function (method, result, url) {
    this.result = result;
    this.method = method;
    this.url = url;
    $("amount-" + this.method).observe("click", this.open.bind(this));
  },
  open: function () {
    var modal = new Element("div", {
      class: "popup-overlay",
      id: "popup-" + this.method,
    });
    var modalContent = new Element("div", {
      class: "popup-content",
    });
    var tableContent = `
  <span class="popup-close">&times;</span>
  <h2>Update Shipping Method Price</h2>
  <button type="button" id="edit-button-${this.method}">Edit</button>
  <table>
    <thead>
      <tr>
        <th colspan="4">${this.method}</th>
      </tr>
      <tr>
        <th>from</th>
        <th>to</th>
        <th>price</th>
        <th id="th-${this.method}" style="display:none;">edit</th>
      </tr>
    </thead>
    <tbody>`;
    if (Array.isArray(this.result)) {
      this.result.forEach(function (shippingMethod) {
        tableContent += `
    <tr>
      <td>${shippingMethod["from"]}</td>
      <td>${shippingMethod["to"] !== null ? shippingMethod["to"] : ""}</td>
      <td>${shippingMethod["price"]}</td>
    </tr>`;
      });
    } else {
      alert("not");
    }

    tableContent += `
    </tbody>
  </table>
  <button type="button" id="save-${this.method}" style="display:none;">save</button>
  <button type="button" id="add-new-${this.method}" style="display:none;">add new Field</button>`;

    modalContent.insert(tableContent);
    modal.update(modalContent);
    document.body.insert(modal);
    $("edit-button-" + this.method).observe("click", this.edit.bind(this));
    $("save-" + this.method).observe("click", this.save.bind(this));

    $$(".popup-close").each(
      function (closeButton) {
        closeButton.observe("click", function () {
          location.reload();
        });
      }.bind(this)
    );
  },
  edit: function () {
    var popupId = "popup-" + this.method;
    var popup = $(popupId);
    var savebutton = "save-" + this.method;
    var save = $(savebutton);
    save.show();
    var editbutton = "edit-button-" + this.method;
    var editButton = $(editbutton);
    var table = popup.down("table");
    var rows = table.select("tr");
    popup.select("td").each(function (td) {
      var originalContent = td.innerHTML.trim();
      td.store("originalContent", originalContent);
      var input = document.createElement("input");
      input.type = "text";
      input.value = td.innerHTML.trim();
      td.innerHTML = "";
      td.appendChild(input);
    });
    rows.each(function (row, index) {
      // Skip the header row
      if (index === 0 || index === 1) return;

      var existingDeleteButton = row.down(".delete-button");
      if (existingDeleteButton) {
        existingDeleteButton.remove();
      }

      var deleteButton = document.createElement("button");
      deleteButton.type = "button";
      deleteButton.innerHTML = "Delete";
      deleteButton.className = "delete-button";
      deleteButton.observe("click", function () {
        row.remove();
      });

      var deleteCell = document.createElement("td");
      deleteCell.appendChild(deleteButton);
      row.appendChild(deleteCell);
    });
    var newRowButton = $("add-new-" + this.method);

    newRowButton.show();
    newRowButton.observe("click", this.addNewRow.bind(this, table));
    $("th-" + this.method).show();
    editButton.disabled = true;
  },
  addNewRow: function (table) {
    var row = document.createElement("tr");
    for (var i = 0; i < 3; i++) {
      var cell = document.createElement("td");
      var input = document.createElement("input");
      input.type = "text";
      cell.appendChild(input);
      row.appendChild(cell);
    }

    var deleteButton = document.createElement("button");
    deleteButton.type = "button";
    deleteButton.innerHTML = "Delete";
    deleteButton.className = "delete-button";
    deleteButton.observe("click", function () {
      row.remove();
    });

    var deleteCell = document.createElement("td");
    deleteCell.appendChild(deleteButton);
    row.appendChild(deleteCell);

    table.appendChild(row);
    document.observe("dom:loaded", function () {
      $$(".edit-button").each(function (button) {
        var methodCode = button.id.replace("edit-button-", "");
        new editData(methodCode);
      });
    });
  },
  save: function () {
    var popupId = "popup-" + this.method;
    var popup = $(popupId);
    var data = {};

    var rows = popup.querySelectorAll("table tr");

    rows.forEach(function (row, index) {
      if (index === 0 || index === 1) return;

      var cells = row.querySelectorAll("td");

      var from = cells[0].querySelector("input").value;
      var to = cells[1].querySelector("input").value;
      var price = cells[2].querySelector("input").value;

      data[
        "groups[whiteglovedelivery][fields][amount][value][" +
          (index - 1) +
          "][from]"
      ] = from;
      data[
        "groups[whiteglovedelivery][fields][amount][value][" +
          (index - 1) +
          "][to]"
      ] = to;
      data[
        "groups[whiteglovedelivery][fields][amount][value][" +
          (index - 1) +
          "][price]"
      ] = price;
    });

    new Ajax.Request(this.url, {
      method: "post",
      parameters: data,
      onSuccess: function (response) {
        alert("Data saved successfully!");
        location.reload();
      },
      onFailure: function () {
        alert("Failed to save data.");
      },
    });
  },
};
