const deleteIdeaBtns = document.getElementsByClassName('deleteBtn');

for(const deleteIdeaBtn of deleteIdeaBtns) {
    deleteIdeaBtn.addEventListener('click', function (event) {
        event.preventDefault();

        fetch(deleteIdeaBtn.getAttribute('href'))
            .then(response => {
                if (response.status === 200) {

                    
                    const confirmation = confirm("Etes vous sûr de vouloir supprimer votre idée?");
                    if (confirmation) {
                        deleteIdeaBtn.parentElement.parentElement.parentElement.remove();
                        const flashMessage = document.createElement('div');
                        flashMessage.classList.add('flash-message');
                        flashMessage.textContent = 'Votre idée a été supprimé.';
                        document.body.appendChild(flashMessage);
        

                        setTimeout(() => {
                            flashMessage.remove();
                        }, 2500);
                    }

                } else {
                    alert("Erreur");
                }
            })
        ;
    });
}






const deleteBtnShow = document.getElementById('deleteBtnShow');


deleteBtnShow.addEventListener('click', function (event) {
    event.preventDefault();

    fetch(deleteBtnShow.getAttribute('href'))
        .then(response => {
            if (response.status === 200) {

                    
                const confirmation = confirm("Etes vous sûr de vouloir supprimer votre idée?");
                if (confirmation) {
                    window.location.replace("http://localhost:8000");
                    const flashMessage = document.createElement('div');
                    flashMessage.classList.add('flash-message');
                    flashMessage.textContent = 'Votre idée a été supprimé.';
                    document.body.appendChild(flashMessage);
        

                    setTimeout(() => {
                        flashMessage.remove();
                    }, 2500);
                }

            } else {
                alert("Erreur");
            }
        })
    ;
});