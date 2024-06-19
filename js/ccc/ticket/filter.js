function openCustomFilterPopup() {
  document.getElementById("custom-filter-popup").style.display = "flex";
}

function closeCustomFilterPopup() {
  document.getElementById("custom-filter-popup").style.display = "none";
}

function submitCustomFilter(saveFilterUrl) {
  event.preventDefault();
  event.stopPropagation();

  let json = JSON.stringify(
    document.querySelector(".custom_filter_form").serialize(true)
  );

  new Ajax.Request(saveFilterUrl, {
    method: "post",
    parameters: { data: json },
    onSuccess: function () {
      alert("Filter save successfully.");
      closeCustomFilterPopup();
    },
    onFailure: function () {
      alert("Failed to save filters.");
      closeCustomFilterPopup();
    },
  });
}

function applyFilter(obj) {
  new Ajax.Request(gridUrl, {
    method: "post",
    parameters: { custom_filter: obj.getAttribute("json-data") },
    onSuccess: function (response) {
      document.body.innerHTML = response.responseText;
    },
    onFailure: function () {
      alert("Failed to save filters.");
    },
  });
}
