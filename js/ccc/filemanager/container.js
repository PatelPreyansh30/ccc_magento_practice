changeFolderPath = function (url) {
  var selectValue = $("folder_path").value;

  new Ajax.Request(url, {
    method: "post",
    evalScripts: true,
    parameters: { value: btoa(selectValue) },
    onSuccess: function (response) {
      $("filemanager-grid").update(response.responseText);
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
      if (obj.getAttribute("changed-name")) {
        input.value = obj.getAttribute("changed-name");
      } else {
        input.value = data.filename;
      }
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
            new_filename: `${input.value}.${data.extension}`,
            old_filename: data.basename,
            fullpath: data.fullpath,
          },
          onSuccess: function (response) {
            var response = JSON.parse(response.responseText);
            if (response.success) {
              obj.innerHTML = input.value;
              obj.setAttribute("changed-name", input.value);

              var download = document.getElementById(`download-${data.id}`);
              var downloadHref = download.getAttribute("href");
              downloadHref = downloadHref.replaceAll(
                data.basename,
                `${input.value}.${data.extension}`
              );
              download.setAttribute("href", downloadHref);

              var deletee = document.getElementById(`delete-${data.id}`);
              var deleteHref = deletee.getAttribute("href");
              deleteHref = deleteHref.replaceAll(
                data.basename,
                `${input.value}.${data.extension}`
              );
              deletee.setAttribute("href", deleteHref);
            } else {
              obj.innerHTML = data.filename;
            }
            obj.classList.remove("editable");

            var inputElements = obj.querySelectorAll("input, button");
            for (var i = 0; i < inputElements.length; i++) {
              inputElements[i].style.display = "none";
            }
            alert(response.message);
          },
        });
      };

      var cancel = document.createElement("button");
      cancel.innerHTML = "Cancel";
      cancel.onclick = function (e) {
        e.preventDefault();
        e.stopPropagation();

        obj.classList.remove("editable");
        if (obj.getAttribute("changed-name")) {
          obj.innerHTML = obj.getAttribute("changed-name");
        } else {
          obj.innerHTML = data.filename;
        }

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

varienGrid.prototype.doSort = function (event) {
  var element = Event.findElement(event, "a");

  this.addVarToUrl("value", btoa($F("folder_path")));

  if (element.name && element.title) {
    this.addVarToUrl(this.sortVar, element.name);
    this.addVarToUrl(this.dirVar, element.title);
    this.reload(this.url);
  }
  Event.stop(event);
  return false;
};

varienGrid.prototype.resetFilter = function () {
  this.addVarToUrl("value", btoa($F("folder_path")));
  this.reload(this.addVarToUrl(this.filterVar, ""));
};

varienGrid.prototype.doFilter = function () {
  var filters = $$(
    "#" + this.containerId + " .filter input",
    "#" + this.containerId + " .filter select"
  );
  var elements = [];

  this.addVarToUrl("value", btoa($F("folder_path")));

  for (var i in filters) {
    if (filters[i].value && filters[i].value.length) elements.push(filters[i]);
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

varienGrid.prototype.setPage = function (pageNumber) {
  this.addVarToUrl("value", btoa($F("folder_path")));
  this.reload(this.addVarToUrl(this.pageVar, pageNumber));
};

varienGrid.prototype.loadByElement = function (element) {
  if (element && element.name) {
    this.addVarToUrl("value", btoa($F("folder_path")));
    this.reload(this.addVarToUrl(element.name, element.value));
  }
};
