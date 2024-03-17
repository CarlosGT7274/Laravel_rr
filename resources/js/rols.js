const checkboxesEnFila = document.querySelectorAll('input[type="checkbox"]');

checkboxesEnFila.forEach(function (cb) {
    const tipo = cb.name.split("[")[2];
    if (tipo === "off]") {
        cb.addEventListener("click", function () {
            const checkboxesEnFila =
                this.parentElement.parentElement.querySelectorAll(
                    'input[type="checkbox"]'
                );

            if (this.checked) {
                checkboxesEnFila.forEach(function (cb) {
                    const name = cb.name.split("[")[2];
                    cb.checked = name === "off]" ? true : false;
                });
            }
        });
    } else if (tipo === "todos]") {
        cb.addEventListener("change", function () {
            const checkboxesEnFila =
                this.parentElement.parentElement.querySelectorAll(
                    'input[type="checkbox"]'
                );

            if (this.checked) {
                checkboxesEnFila.forEach(function (cb) {
                    const name = cb.name.split("[")[2];
                    cb.checked = name !== "off]" ? true : false;
                });
            }
        });
    } else if (tipo === "on]") {
        cb.addEventListener("change", function () {
            const checkboxesEnFila =
                this.parentElement.parentElement.querySelectorAll(
                    'input[type="checkbox"]'
                );

            if (!this.checked) {
                checkboxesEnFila.forEach(function (cb) {
                    const name = cb.name.split("[")[2];
                    if (name === "off]") {
                        cb.checked = true;
                    } else {
                        cb.checked = false;
                    }
                });
            } else {
                checkboxesEnFila.forEach(function (cb) {
                    const name = cb.name.split("[")[2];
                    if (name === "off]") {
                        cb.checked = false;
                    }
                });
            }
        });
    } else {
        cb.addEventListener("change", function () {
            const checkboxesEnFila =
                this.parentElement.parentElement.querySelectorAll(
                    'input[type="checkbox"]'
                );

            checkboxesEnFila.forEach(function (cb) {
                const name = cb.name.split("[")[2];
                if (name === "off]") {
                    cb.checked = false;
                } else if (name === "on]") {
                    cb.checked = true;
                } else if (name === "todos]") {
                    cb.checked = false;
                }
            });

            if (this.checked) {
                this.checked = true;
            }
        });
    }
});
