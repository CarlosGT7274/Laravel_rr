let fileInput = document.getElementById("file-input");

fileInput.addEventListener("change", function () {
    const label = document.querySelector("label[for=file-input]");
    label.classList.add("hidden");
    label.parentElement.classList.add("hidden");

    if (this.files && this.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            const image = document.getElementById("pp");
            image.classList.remove("hidden");
            image.src = e.target.result;

            document.getElementById("buttons").classList.remove("hidden");
        };
        reader.readAsDataURL(this.files[0]);
    }
});

document.getElementById("remove").onclick = function () {
    const image = document.getElementById("pp");
    image.classList.add("hidden");
    image.src = "";

    document.getElementById("buttons").classList.add("hidden");

    const label = document.querySelector("label[for=file-input]");
    label.classList.remove("hidden");
    label.parentElement.classList.remove("hidden");

    document.getElementById("file-input").value = "";
};
