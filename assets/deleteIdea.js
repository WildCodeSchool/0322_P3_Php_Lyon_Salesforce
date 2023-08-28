document.addEventListener("DOMContentLoaded", function () {
    const deleteForms = document.querySelectorAll(".deleteForm");

    deleteForms.forEach((form) => {
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            const submitButton = form.querySelector(".deleteBtn");
            submitButton.disabled = true;

            fetch(form.action, {
                method: "POST",
                body: new FormData(form),
            }).then((response) => {
                if (response.status === 200) {
                    const colParent = form.closest(".col");
                    colParent.remove();

                    const flashMessage = document.createElement("div");
                    flashMessage.classList.add("alert", "alert-success", "flash-message");
                    flashMessage.textContent = "L'idée a bien été supprimée.";
                    flashMessage.setAttribute("role", "alert");

                    document.querySelector(".container").appendChild(flashMessage);

                    setTimeout(() => {
                        flashMessage.remove();
                    }, 2500);
                } else {
                    alert("Erreur");
                }
            });
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const deleteBtnShow = document.getElementById("deleteBtnShow");

    deleteBtnShow.addEventListener("submit", function (event) {
        event.preventDefault();

        fetch(deleteBtnShow.action, {
            method: "POST",
            body: new FormData(deleteBtnShow),
        }).then((response) => {
            if (response.status === 200) {
                location.href = "/";
            } else {
                alert("Erreur");
            }
        });
    });
});
