changeFolderPath = function (url) {
  var selectValue = $("folder_path").value;

  new Ajax.Request(url, {
    method: "post",
    parameters: { value: selectValue },
    onSuccess: function (response) {
      document.open();
      document.write(response.responseText);
      document.close();
    },
  });
};
