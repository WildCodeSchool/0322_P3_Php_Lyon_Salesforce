/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

require('bootstrap');

// SideBar Javascript

const sidebar = document.getElementById('sidebar');

function updateSidebarClasses() {
    if (window.innerWidth < 768) {
        sidebar.classList.remove('collapse', 'collapse-horizontal', 'show', 'rounded-end');
        sidebar.classList.add('offcanvas', 'offcanvas-end', 'w-50', 'rounded-start');
    } else {
        sidebar.classList.remove('offcanvas', 'offcanvas-end', 'w-50', 'rounded-start');
        sidebar.classList.add('collapse', 'collapse-horizontal', 'show', 'rounded-end');
    }
}

updateSidebarClasses();

window.addEventListener('resize', updateSidebarClasses);

// End SideBar Javascript
