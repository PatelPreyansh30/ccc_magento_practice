changeFolderPath = function (url) {
  var selectValue = $("folder_path").value;

  new Ajax.Request(url, {
    method: "post",
    parameters: { value: selectValue },
    onSuccess: function (response) {
      document.open();
      document.write(response.responseText);
      document.close();
      $("folder_path").value = selectValue;
    },
  });
};

function inlineChange(obj) {
  var data = JSON.parse(obj.getAttribute("data"));

  obj.classList.toggle("editable");

  if (obj.classList.contains("editable")) {
    if (!obj.querySelector("input")) {
      var input = document.createElement("input");
      input.type = "text";
      input.value = data.filename;
      input.name = "filename";

      var submit = document.createElement("button");
      submit.innerHTML = "Submit";
      submit.onclick = function (e) {
        e.preventDefault();
        e.stopPropagation();

        var url = obj.getAttribute("url");
        new Ajax.Request(url, {
          method: "post",
          parameters: {
            new_filename: input.value,
            old_filename: data.filename,
            fullpath: data.fullpath,
          },
          onSuccess: function (response) {
            var response = JSON.parse(response.responseText);
            if (response.success) {
              obj.innerHTML = input.value;
            } else {
              obj.innerHTML = data.filename;
            }
            obj.classList.remove("editable");

            var inputElements = obj.querySelectorAll("input, button");
            for (var i = 0; i < inputElements.length; i++) {
              inputElements[i].style.display = "none";
            }
            console.log(response);
            Prototype.emptyFunction;
          },
        });
      };

      var cancel = document.createElement("button");
      cancel.innerHTML = "Cancel";
      cancel.onclick = function (e) {
        e.preventDefault();
        e.stopPropagation();

        obj.classList.remove("editable");
        obj.innerHTML = data.filename;

        var inputElements = obj.querySelectorAll("input, button");
        for (var i = 0; i < inputElements.length; i++) {
          inputElements[i].style.display = "none";
        }
      };

      obj.innerHTML = "";
      obj.appendChild(input);
      obj.appendChild(submit);
      obj.appendChild(cancel);
    }

    var inputElements = obj.querySelectorAll("input, button");
    for (var i = 0; i < inputElements.length; i++) {
      inputElements[i].style.display = "block";
    }
  } else {
    console.log("Making non-editable");
  }
}
