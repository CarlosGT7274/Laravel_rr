let fileInput = document.getElementById("file-input");

function getIcon(file_name) {
    let name = "fa-file-";

    let parts = file_name.split(".");
    let file_type = parts[parts.length - 1];

    if (file_type === "rtf" || file_type === "doc" || file_type === "docx") {
        name += "word";
    } else if (file_type === "csv") {
        name += "csv";
    } else if (file_type === "xls" || file_type === "xlsx") {
        name += "excel";
    } else if (file_type === "ppt" || file_type === "pptx") {
        name += "powerpoint";
    } else if (
        file_type === "rar" ||
        file_type === "7z" ||
        file_type === "zip"
    ) {
        name += "zipper";
    } else if (file_type === "txt") {
        name += "lines";
    } else if (file_type === "pdf") {
        name += "pdf";
    } else if (file_type === "xml" || file_type === "json") {
        name += "code";
    } else if (file_type === "mp3" || file_type === "wav") {
        name += "audio";
    } else if (
        file_type === "mp4" ||
        file_type === "avi" ||
        file_type === "webm"
    ) {
        name += "video";
    } else if (
        file_type === "jpg" ||
        file_type === "jpeg" ||
        file_type === "png" ||
        file_type === "gif" ||
        file_type === "bmp" ||
        file_type === "svg" ||
        file_type === "webp"
    ) {
        name += "image";
    } else {
        name += "circle-xmark";
    }

    return name;
}

function getColor(file_name) {
    let name = "text-";

    let parts = file_name.split(".");
    let file_type = parts[parts.length - 1];

    if (file_type === "rtf" || file_type === "doc" || file_type === "docx" || file_type === "txt") {
        name += "primary";
    } else if (file_type === "csv" || file_type === "xls" || file_type === "xlsx") {
        name += "success";
    } else if (file_type === "ppt" || file_type === "pptx") {
        name += "orange-500";
    } else if (
        file_type === "rar" ||
        file_type === "7z" ||
        file_type === "zip"
    ) {
        name += "amber-400";
    } else if (file_type === "pdf") {
        name += "red-800";
    } else if (file_type === "xml" || file_type === "json") {
        name += "success";
    } else if (file_type === "mp3" || file_type === "wav") {
        name += "red-400";
    } else if (
        file_type === "mp4" ||
        file_type === "avi" ||
        file_type === "webm"
    ) {
        name += "purple-700";
    } else if (
        file_type === "jpg" ||
        file_type === "jpeg" ||
        file_type === "png" ||
        file_type === "gif" ||
        file_type === "bmp" ||
        file_type === "svg" ||
        file_type === "webp"
    ) {
        name += "cyan-500";
    } else {
        name += "danger";
    }

    return name;
}

fileInput.addEventListener("change", function () {
    const label = document.querySelector("label[for=file-input]");
    label.classList.add("hidden");
    label.parentElement.classList.add("hidden");

    document.getElementById("file_container").classList.remove("hidden");
    document.getElementById("file_container").classList.add("flex");

    document.getElementById("file_name").innerText = this.files[0].name;
    document
        .getElementById("file_icon")
        .classList.add(getIcon(this.files[0].name));

    document
        .getElementById("file_icon")
        .classList.add(getColor(this.files[0].name));
});

document.getElementById("remove").onclick = function () {
    const label = document.querySelector("label[for=file-input]");
    label.classList.remove("hidden");
    label.parentElement.classList.remove("hidden");

    document.getElementById("file_container").classList.add("hidden");
    document.getElementById("file_container").classList.remove("flex");

    let fileInput = document.getElementById("file-input");

    document.getElementById("file_name").innerText = "";
    document
        .getElementById("file_icon")
        .classList.remove(getIcon(fileInput.files[0].name));
    document
        .getElementById("file_icon")
        .classList.remove(getColor(fileInput.files[0].name));

    fileInput.value = "";
};
