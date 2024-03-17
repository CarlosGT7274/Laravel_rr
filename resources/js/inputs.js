const enableButtons = document.getElementsByName("activarBtn");

for (let i = 0; i < enableButtons.length; i++) {
    enableButtons[i].addEventListener("click", function () {
        const form = this.closest("form");
        const inputs = form.getElementsByTagName("input");
        const textAreas = form.getElementsByTagName("textarea");
        const selects = form.getElementsByTagName("select");
        const buttons = form.querySelectorAll("button:disabled");

        for (
            let i = 0;
            i < inputs.length ||
            i < selects.length ||
            i < buttons.length ||
            i < textAreas.length;
            i++
        ) {
            if (i < textAreas.length) {
                textAreas[i].removeAttribute("readonly");
                textAreas[i].style.cursor = "auto";
                textAreas[i].style.color = "#0d0d0d";
                textAreas[i].style.borderColor = "#0F4B80";
            }
            if (i < inputs.length) {
                inputs[i].removeAttribute("readonly");
                inputs[i].style.cursor = "auto";
                inputs[i].style.color = "#0d0d0d";
                inputs[i].style.borderColor = "#0F4B80";

                if (inputs[i].type == "radio") {
                    const labels =
                        inputs[i].parentElement.getElementsByTagName("label");

                    for (let j = 0; j < labels.length; j++) {
                        labels[j].style.color = "#0d0d0d";
                        labels[j].style.cursor = "pointer";
                    }

                    inputs[i].parentElement.parentElement.style.borderColor =
                        "#0F4B80";
                }
            }

            if (i < selects.length) {
                selects[i].removeAttribute("disabled");
                selects[i].style.cursor = "auto";
                selects[i].style.borderColor = "#0F4B80";
            }

            if (i < buttons.length) {
                buttons[i].removeAttribute("disabled");
                buttons[i].style.cursor = "auto";
                buttons[i].classList.remove("disabled_addUser_btn");
                buttons[i].classList.add("addUser_btn");
            }
        }

        // Mostrar botón de envío y botón de cancelar
        this.style.display = "none";
        form.querySelector('[name="enviarBtn"]').style.display = "inline";
        form.querySelector('[name="cancelarBtn"]').style.display = "inline";
    });
}

const cancelButtons = document.getElementsByName("cancelarBtn");
for (let i = 0; i < cancelButtons.length; i++) {
    cancelButtons[i].addEventListener("click", function () {
        const form = this.closest("form");
        const inputs = form.getElementsByTagName("input");
        const textAreas = form.getElementsByTagName("textarea");
        const selects = form.getElementsByTagName("select");
        const buttons = form.querySelectorAll('button[name="boton"]');

        for (
            let i = 0;
            i < inputs.length ||
            i < selects.length ||
            i < buttons.length ||
            i < textAreas.length;
            i++
        ) {
            if (i < textAreas.length) {
                textAreas[i].setAttribute("readonly", "readonly");
                textAreas[i].style.cursor = "default";
                textAreas[i].style.color = "#8c8c8b";
                textAreas[i].style.borderColor = "#8c8c8b";
            }
            if (i < inputs.length) {
                inputs[i].setAttribute("readonly", "readonly");
                inputs[i].style.cursor = "default";
                inputs[i].style.color = "#8c8c8b";
                inputs[i].style.borderColor = "#8c8c8b";

                if (inputs[i].type === "radio") {
                    const labels =
                        inputs[i].parentElement.getElementsByTagName("label");

                    for (let j = 0; j < labels.length; j++) {
                        labels[j].style.color = "#8c8c8b";
                        labels[j].style.cursor = "default";
                    }

                    inputs[i].parentElement.parentElement.style.borderColor =
                        "#8c8c8b";
                } else {
                    inputs[i].value = inputs[i].defaultValue;
                }
            }

            if (i < selects.length) {
                selects[i].setAttribute("disabled", "disabled");
                selects[i].style.cursor = "default";
                selects[i].style.borderColor = "#8c8c8b";
            }

            if (i < buttons.length) {
                buttons[i].setAttribute("disabled", "disabled");
                buttons[i].style.cursor = "default";
                buttons[i].classList.remove("addUser_btn");
                buttons[i].classList.add("disabled_addUser_btn");
            }
        }

        // Ocultar botón de envío y botón de cancelar
        form.querySelector('[name="activarBtn"]').style.display = "inline";
        form.querySelector('[name="enviarBtn"]').style.display = "none";
        this.style.display = "none";
    });
}
