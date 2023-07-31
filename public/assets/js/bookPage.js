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
      deleteImg.classList.add("test");
      // Add the div to the modal, and images to div
      document.getElementById("imagesBox").prepend(imgBox);
      imgBox.appendChild(img).setAttribute("src", e.target.result);
      const images = document.querySelectorAll("#imagesBox .modal-img-js");
      const deleteSrc = "assets/images/delete.webp";
      imgBox.appendChild(deleteImg).setAttribute("src", deleteSrc);
      // Check if the number of the images in the modal < 6 => add img
      if (images.length == 6) {
        document.getElementById("uploadImgControls").style.display = "none";
      } else {
        document.getElementById("uploadImgControls").style.display = "block";
      }
    };

    reader.readAsDataURL(input.files[0]);
  }
}

// End Modal Images Container
