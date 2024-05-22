var j = jQuery.noConflict();

j(document).ready(function () {
  var field = {};
  var editUrl;
  j("body").on("click", ".edit-row", function (e) {
    e.preventDefault();
    var editButton = j(this);
    var entityId = editButton.data("entity-id");
    editUrl = editButton.data("url");
    field = editButton.data("field");

    var row = editButton.closest("tr");
    var editableCells = row.find("td.editable");

    editableCells.each(function () {
      let originalValue = j(this).text().trim();

      j(this).html(
        '<input type="text" class="edit-input" value="' +
          originalValue +
          '" data-original="' +
          originalValue +
          '">'
      );
    });

    editButton.hide();

    var saveButton = j(
      '<a  href="#" data-edit-url="' +
        editUrl +
        '" data-entity-id="' +
        entityId +
        '" class="save-button">Save</a>'
    );
    var cancelButton = j(
      '<a href="#" style="padding-left:5px" data-edit-url="' +
        editUrl +
        '" data-entity-id="' +
        entityId +
        '"  class="cancel-button">Cancel</a>'
    );
    var buttonContainer = j("<div>")
      .addClass("button-container")
      .append(saveButton, cancelButton);

    var cell = editButton.closest("td");
    cell.empty().append(buttonContainer);

    editableCells.first().find(".edit-input").focus();
  });

  j("body").on("click", ".save-button", function (e) {
    e.preventDefault();
    var saveButton = j(this);
    var row = saveButton.closest("tr");
    var editableCells = row.find("td.editable");
    var entityId = saveButton.data("entity-id");
    var editedData = {};

    editableCells.each(function (index) {
      var fieldName = field[index];
      var value;
      value = j(this).find(".edit-input").val().trim();
      editedData[fieldName] = value;

      j(this).text(value);
    });
    editedData["id"] = entityId;
    new Ajax.Request(editUrl, {
      method: "post",
      parameters: editedData,
    });
    var cell = saveButton.closest("td");
    var a = new Element("a");
    a.innerText = "Edit";
    a.setAttribute("href", "#");
    a.setAttribute("class", "edit-row");
    a.setAttribute("data-url", editUrl);
    a.setAttribute("data-entity-id", entityId);
    cell.empty().html(a);
  });

  j("body").on("click", ".cancel-button", function (e) {
    e.preventDefault();

    var cancelButton = j(this);
    var row = cancelButton.closest("tr");
    var editableCells = row.find("td.editable");
    var entityId = cancelButton.data("entity-id");

    editableCells.each(function (index) {
      var originalValue;
      originalValue = j(this).find(".edit-input").data("original");
      j(this).text(originalValue);
    });

    var cell = cancelButton.closest("td");
    var a = new Element("a");
    a.innerText = "Edit";
    a.setAttribute("href", "#");
    a.setAttribute("class", "edit-row");
    a.setAttribute("data-url", editUrl);
    a.setAttribute("data-entity-id", entityId);
    cell.empty().html(a);
  });
});
