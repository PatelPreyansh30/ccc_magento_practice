function getValuesFromElements() {
  let ticket_id = document.getElementById("ticket_id-filter").value;
  let title = document.getElementById("title-filter").value;
  let description = document.getElementById("description-filter").value;
  let admin_user = document.getElementById("admin_user-filter").value;
  let assign_by = document.getElementById("assign_by-filter").value;
  let status = document.getElementById("status-filter").value;
  let priority = document.getElementById("priority-filter").value;

  let parameters = {
    ticket_id,
    title,
    description,
    admin_user,
    assign_by,
    status,
    priority,
  };
  return parameters;
}

function resetFilter() {
  let parameters = getValuesFromElements();

  for (const key in parameters) {
    parameters[key] = "";
  }
  filterAjax(parameters);
}

function searchFilter() {
  let parameters = getValuesFromElements();
  filterAjax(parameters);
}

function filterAjax(parameters) {
  new Ajax.Request(gridUrl, {
    method: "post",
    parameters: { filter_data: JSON.stringify(parameters) },
    onSuccess: function (response) {
      document.body.innerHTML = response.responseText;
    },
    onFailure: function () {
      alert("Failed to apply filter.");
    },
  });
}

var sorting_array = {};

function sorting(obj) {
  const key = obj.getAttribute("column");
  if (sorting_array[key]) {
    if (sorting_array[key] == "ASC") {
      sorting_array[key] = "DESC";
    } else if (sorting_array[key] == "DESC") {
      sorting_array[key] = "ASC";
    }
  } else {
    sorting_array[key] = "ASC";
  }

  const newSortingArray = {};
  newSortingArray[key] = sorting_array[key];
  sorting_array = newSortingArray;

  new Ajax.Request(gridUrl, {
    method: "post",
    parameters: { sorting_data: JSON.stringify(sorting_array) },
    onSuccess: function (response) {
      document.body.innerHTML = response.responseText;
    },
    onFailure: function () {
      alert("Failed to apply sorting.");
    },
  });
}
