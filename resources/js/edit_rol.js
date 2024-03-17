const input = document.getElementById("Nrol");

const editactiavate = document.getElementById("edtinput");

const limpiarBtn = document.getElementById("limpiarBtn");

const save = document.getElementById("saveIcon");

editactiavate.addEventListener("click", () => {
    const permisosC = document.querySelectorAll('input[type="checkbox"]');

    input.classList.remove("cursor-not-allowed", "pointer-events-none");
    editactiavate.classList.add("hidden");
    save.classList.remove("hidden");
    limpiarBtn.classList.remove("hidden");
    permisosC.forEach((checkbox) => {
        checkbox.classList.remove("cursor-not-allowed", "pointer-events-none");
    });
});

limpiarBtn.addEventListener("click", () => {
    const permisosC = document.querySelectorAll('input[type="checkbox"]');

    input.classList.add("cursor-not-allowed", "pointer-events-none");
    editactiavate.classList.remove("hidden");
    save.classList.add("hidden");
    limpiarBtn.classList.add("hidden");
    permisosC.forEach((checkbox) => {
        checkbox.classList.add("cursor-not-allowed", "pointer-events-none");
    });

    input.value = input.defaultValue;
    permisosC.forEach((checkbox) => {
        checkbox.checked = checkbox.defaultValue;
    });
});
