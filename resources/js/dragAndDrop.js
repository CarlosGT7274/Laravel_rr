var dropArea = document.getElementById("drop-area");
var fileInput = document.getElementById("file-input");

dropArea.addEventListener("dragover", function (event) {
    event.preventDefault();
    event.dataTransfer.dropEffect = "copy";
});

dropArea.addEventListener("drop", function (event) {
    event.preventDefault();

    fileInput.files = event.dataTransfer.files;

    let changeEvent = new Event("change");

    fileInput.dispatchEvent(changeEvent);
});
