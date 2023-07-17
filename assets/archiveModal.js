var archiveModal = document.getElementById("archiveIdeaModal");
archiveModal.addEventListener("show.bs.modal", function (event) {
    var button = event.relatedTarget;
    var ideaId = button.getAttribute("data-idea-id");
    var confirmArchiving = document.getElementById("confirmArchiving");
    confirmArchiving.setAttribute(
        "href",
        "/ArchivesIdea/ideaId".replace("ideaId", ideaId)
    );
});
