document.addEventListener("DOMContentLoaded", function () {
  var eventsData = JSON.parse(
    document.getElementById("events-data-json").textContent
  );
  if (eventsData && eventsData.length != 0) {
    for (var eventIndex in eventsData) {
      page_tabsJsTabs.addNewRowSection(
        eventsData[eventIndex],
        eventsData[eventIndex].event_id,
        eventsData[eventIndex].group_id
      );
    }
  }
});

varienTabs.prototype.addEvent = function () {
  event.preventDefault();
  this.addNewRowSection();
};

varienTabs.prototype.addNewRowSection = function (
  eventData,
  event_id,
  group_id
) {
  var section = document.createElement("div");
  section.className = "new-row-section";

  var eventIndex =
    typeof event_id !== "undefined"
      ? event_id
      : document.querySelectorAll(".new-row-section").length;

  var eventNameField = document.createElement("input");
  eventNameField.type = "text";
  eventNameField.name = `event[${eventIndex}][event_name]`;
  eventNameField.className = "eventname";
  eventNameField.placeholder = "Event Name";
  if (eventData && eventData.rows && eventData.rows[0].event_name) {
    eventNameField.value = eventData.rows[0].event_name;
  }
  section.appendChild(eventNameField);

  if (eventData && eventData.rows && eventData.rows[0].group_id) {
    var groupIdField = document.createElement("input");
    groupIdField.type = "hidden";
    groupIdField.name = `event[${eventIndex}][group_id]`;
    groupIdField.className = "group_id";
    groupIdField.value = eventData.rows[0].group_id;
    section.appendChild(groupIdField);
  }

  var addButton = document.createElement("button");
  addButton.type = "button";
  addButton.className = "add-button";
  addButton.textContent = "Add New Row";
  addButton.onclick = function () {
    var newRow = page_tabsJsTabs.createRow(eventIndex);
    if (newRow) {
      section.appendChild(newRow);
    }
  };
  section.appendChild(addButton);

  var deleteEventButton = document.createElement("button");
  deleteEventButton.type = "button";
  deleteEventButton.className = "delete-button";
  deleteEventButton.textContent = "Delete Event";
  deleteEventButton.onclick = function () {
    section.remove();
  };
  section.appendChild(deleteEventButton);

  if (eventData && eventData.rows) {
    eventData.rows.forEach(function (rowData, rowIndex) {
      var row = page_tabsJsTabs.createRow(eventIndex, rowData, rowIndex);
      if (row) {
        section.appendChild(row);
      }
    });
  } else {
    var initialRow = page_tabsJsTabs.createRow(eventIndex);
    if (initialRow) {
      section.appendChild(initialRow);
    }
  }

  document.getElementById("new-row-container").appendChild(section);
};

varienTabs.prototype.createRow = function (eventIndex, rowData, rowIndex) {
  var row = document.createElement("div");
  row.className = "new-row";
  rowIndex =
    typeof rowIndex !== "undefined"
      ? rowIndex
      : document.querySelectorAll(
          `.new-row-section:nth-of-type(${eventIndex + 1}) .new-row`
        ).length;
  var dropdown1 = this.createDropdown(["From", "Subject"]);
  dropdown1.name = `event[${eventIndex}][rows][${rowIndex}][name]`;
  if (rowData && rowData.name) {
    dropdown1.value = rowData.name;
  }

  var dropdown2 = this.createDropdown(["Like", "%Like%", "=="]);
  dropdown2.name = `event[${eventIndex}][rows][${rowIndex}][operator]`;
  if (rowData && rowData.operator) {
    dropdown2.value = rowData.operator;
  }

  var textbox = document.createElement("input");
  textbox.type = "text";
  textbox.placeholder = "value";
  textbox.name = `event[${eventIndex}][rows][${rowIndex}][value]`;
  textbox.className = "textbox";
  if (rowData && rowData.value) {
    textbox.value = rowData.value;
  }
  if (rowData && rowData.event_id) {
    var eventId = document.createElement("input");
    eventId.type = "hidden";
    eventId.name = `event[${eventIndex}][rows][${rowIndex}][event_id]`;
    eventId.className = "eventId";
    eventId.value = rowData.event_id;
    row.appendChild(eventId);
  }

  var deleteRowButton = document.createElement("button");
  deleteRowButton.type = "button";
  deleteRowButton.className = "delete-button";
  deleteRowButton.textContent = "Delete Row";
  deleteRowButton.onclick = function () {
    row.remove();
  };

  row.appendChild(dropdown1);
  row.appendChild(dropdown2);
  row.appendChild(textbox);
  row.appendChild(deleteRowButton);
  return row;
};
varienTabs.prototype.createDropdown = function (options) {
  var select = document.createElement("select");
  select.className = "dropdown";
  options.forEach(function (option) {
    var opt = document.createElement("option");
    opt.value = option.toLowerCase().replace(" ", "");
    opt.textContent = option;
    select.appendChild(opt);
  });
  return select;
};
