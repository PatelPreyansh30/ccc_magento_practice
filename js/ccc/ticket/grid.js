function getValuesFromElements() {
  let elements = document.querySelectorAll(".grid_filter");
  let parameters = {};
  elements.forEach((element) => {
    parameters[element.name] = element.value;
  });
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
