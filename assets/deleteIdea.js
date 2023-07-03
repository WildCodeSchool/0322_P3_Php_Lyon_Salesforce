const deleteIdeaBtns = document.getElementsByClassName('deleteBtn');

const deleteIdea = document.getElementsByClassName('deleteIdea');

for(const deleteIdeaBtn of deleteIdeaBtns) {
    deleteIdeaBtn.addEventListener('click', function (event) {
        event.preventDefault();

        fetch(deleteIdeaBtn.getAttribute('href'))
            .then(response => {
                if (response.status === 200) {

                    deleteIdeaBtn.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.remove();
                    const flashMessage = document.createElement('div');
                    flashMessage.classList.add('flash-message');
                    flashMessage.textContent = 'Votre idée a été supprimé.';
                    document.body.appendChild(flashMessage);


                    setTimeout(() => {
                        flashMessage.remove();
                    }, 2500);


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

                window.location.replace("http://localhost:8000");
                const flashMessage = document.createElement('div');
                flashMessage.classList.add('flash-message');
                flashMessage.textContent = 'Votre idée a été supprimé.';
                document.body.appendChild(flashMessage);


                setTimeout(() => {
                    flashMessage.remove();
                }, 2500);


            } else {
                alert("Erreur");
            }
        })
    ;
});
