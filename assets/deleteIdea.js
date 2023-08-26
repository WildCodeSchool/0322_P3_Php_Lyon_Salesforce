const deleteIdeaBtns = document.getElementById("deleteBtn");

// Function to handle the click event
function handleDeleteButtonClick(event) {
    event.preventDefault();

    const deleteIdeaBtn = event.target;

    fetch(deleteIdeaBtn.getAttribute("form")).then((response) => {
        if (response.status === 200) {
            const ideaContainer = deleteIdeaBtn.closest(".col");
            ideaContainer.remove();

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
}

// Remove any existing click event listeners from delete buttons
for (const deleteIdeaBtn of deleteIdeaBtns) {
    deleteIdeaBtn.removeEventListener("click", handleDeleteButtonClick);
}

// Attach the click event listener to delete buttons
for (const deleteIdeaBtn of deleteIdeaBtns) {
    deleteIdeaBtn.addEventListener("click", handleDeleteButtonClick);
}

const deleteBtnShow = document.getElementById("deleteBtnShow");

deleteBtnShow.addEventListener("click", function (event) {
    event.preventDefault();

    fetch(deleteBtnShow.getAttribute("form")).then((response) => {
        if (response.status === 200) {
            location.href = "/";
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
