// Start 'like' reaction button action
const like = document.querySelectorAll(".like-reaction-btn");
like.forEach((e) => {
  e.addEventListener("click", () => e.classList.toggle("clicked"));
});
// End 'like' reaction button action

// Start auto resize textarea - write comment box
const textArea = document.getElementsByTagName("textarea");
for (let i = 0; i < textArea.length; i++) {
  textArea[i].setAttribute(
    "style",
    "height:" + textArea[i].scrollHeight + "px;overflow-y:hidden;"
  );
  textArea[i].addEventListener("input", OnInput, false);
}

function OnInput() {
  this.style.height = 0;
  this.style.height = this.scrollHeight + "px";
}
// End auto resize textarea - write comment box

// Start MrModal
// const openModal = document.getElementById("openMrModal");
const closeModal = document.getElementById("closeModal");
const modalContainer = document.getElementById("modalContainer");
const postBtn = document.getElementById("postBtn");
const startPost = document.querySelectorAll(".start-post");

// Open MrModal
// openModal.onclick = openMrModal(modalContainer);
postBtn.onclick = closeMrModal(modalContainer);
startPost.forEach((element) => (element.onclick = openMrModal(modalContainer)));

function openMrModal(modal) {
  return function () {
    modal.classList.add("show-modal");
  };
}

// Close MrModal
closeModal.onclick = closeMrModal(modalContainer);

function closeMrModal(modal) {
  return function () {
    modal.classList.remove("show-modal");
  };
}

// Hide modal on outside click

window.addEventListener("click", (e) =>
  e.target == modalContainer
    ? modalContainer.classList.remove("show-modal")
    : false
);

// End MrModal

// Start Modal Images Container
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      // Create The Img Box, main img, and the deleteIcon
      var imgBox = document.createElement("div");
      imgBox.classList.add("img-box");
      var img = document.createElement("img");
      img.classList.add("modal-img-js");
      var deleteImg = document.createElement("img");
      deleteImg.classList.add("delete-img");
      // Add the div to the modal, and images to div
      document.getElementById("imagesBox").prepend(imgBox);
      imgBox.appendChild(img).setAttribute("src", e.target.result);
      const deleteSrc = "assets/images/close.png";
      imgBox.appendChild(deleteImg).setAttribute("src", deleteSrc);
    };

    reader.readAsDataURL(input.files[0]);
  }
}

// End Modal Images Container

// Start Remove Image From The Modal
document.addEventListener("click", function (event) {
  if (event.target.classList.contains("delete-img")) {
    // Remove parent element of the clicked delete-img element
    event.target.parentNode.remove();
  }
});
// End Remove Image From The Modal




