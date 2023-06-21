const deleteIdeaBtns = document.getElementsByClassName('deleteBtn');

for(const deleteIdeaBtn of deleteIdeaBtns) {
    deleteIdeaBtn.addEventListener('click', function (event) {
        event.preventDefault();

        fetch(deleteIdeaBtn.getAttribute('href'))
            .then(response => {
                if(response.status != 200 ) alert("Erreur");
            
            })
        ;
    });
}