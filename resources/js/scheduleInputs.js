const radiosL = [];
const radiosD = [];

for (let i = 0; i < 7; i++) {
    radiosD.push(document.getElementById(`D${i}`));
    radiosL.push(document.getElementById(`L${i}`));
}

radiosD.forEach((radio, i) => {
    radio.addEventListener("change", function () {
        const divGrupo = radio.closest(".detalles-wrapper");
        const inputsGroup = divGrupo.querySelectorAll(".detail-input");

        inputsGroup.forEach((group) => {
            const input = group.querySelector("input");

            if (input.type == "time") {
                if (input.name == `detalles[${i}][inicio]`) {
                    input.value = "00:00:00";
                } else if (input.name == `detalles[${i}][fin]`) {
                    input.value = "23:59:59";
                }
            } else {
                input.value = 0;
            }

            input.classList.remove("text-dark");
            input.classList.add("text-ldark");

            input.readOnly = true;
        });
    });

    if(radio.checked) {
        const divGrupo = radio.closest(".detalles-wrapper");
        const inputsGroup = divGrupo.querySelectorAll(".detail-input");

        inputsGroup.forEach((group) => {
            const input = group.querySelector("input");

            if (input.type == "time") {
                if (input.name == `detalles[${i}][inicio]`) {
                    input.value = "00:00:00";
                } else if (input.name == `detalles[${i}][fin]`) {
                    input.value = "23:59:59";
                }
            } else {
                input.value = 0;
            }

            input.classList.remove("text-dark");
            input.classList.add("text-ldark");

            input.readOnly = true;
        });
    }
});

radiosL.forEach((radio) => {
    radio.addEventListener("change", function () {
        const divGrupo = radio.closest(".detalles-wrapper");
        const inputsGroup = divGrupo.querySelectorAll(".detail-input");

        inputsGroup.forEach((group) => {
            const input = group.querySelector("input");

            input.value = "";

            input.classList.remove("text-ldark");
            input.classList.add("text-dark");

            input.readOnly = false;
        });
    });
});

const inputsTime = document.querySelectorAll('input[type="time"]');

inputsTime.forEach(function (input) {
    input.addEventListener("input", function () {
        input.value = input.value.replace(/:\d{2}$/, ":00");
    });
});
