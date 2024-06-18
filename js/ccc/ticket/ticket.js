function openCreateTicketPopup() {
  document.getElementById("popup-overlay").style.display = "flex";
}

function closeCreateTicketPopup() {
  document.getElementById("popup-overlay").style.display = "none";
}

function updateTicket(obj, type) {
  let parameters = { id: ticketId };

  if (type === "status") {
    parameters.status = obj.value.trim();
  } else if (type === "assignTo") {
    parameters.admin_user = obj.value.trim();
  } else if (type === "assignBy") {
    parameters.assign_by = obj.value.trim();
  }

  new Ajax.Request(saveUrl, {
    method: "post",
    parameters: parameters,
    onSuccess: function (response) {
      document.body.innerHTML = response.responseText;
    },
    onFailure: function () {
      alert("Failed to save ticket.");
    },
  });
}

function addComment() {
  event.preventDefault();

  let comment = document.getElementById("ticket-comment");

  if (comment.value.trim() == "") {
    return false;
  }
  new Ajax.Request(saveCommentUrl, {
    method: "post",
    parameters: { ticket_id: ticketId, comment: comment.value.trim() },
    onSuccess: function (response) {
      location.reload();
    },
    onFailure: function () {
      alert("Failed to save ticket.");
    },
  });
}
