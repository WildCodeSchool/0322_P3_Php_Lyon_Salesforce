const deleteIdeaBtns = document.getElementsByClassName('deleteBtn');

for(const deleteIdeaBtn of deleteIdeaBtns) {
    deleteIdeaBtn.addEventListener('click', function (event) {
        event.preventDefault();

        fetch(deleteIdeaBtn.getAttribute('href'))
            .then(response => {
                if (response.status === 200) {

                    deleteIdeaBtn.parentElement.parentElement.parentElement.remove();
                    const flashMessage = document.createElement('div');
                    flashMessage.classList.add('flash-message');
                    flashMessage.textContent = 'Votre idée a été supprimé.';
                    document.body.appendChild(flashMessage);
        
                    // Remove the flash message after a certain duration (e.g., 3 seconds)
                    setTimeout(() => {
                        flashMessage.remove();
                    }, 2000);
                
                } else {
                    alert("Erreur");
                }
            })
        ;
    });
}