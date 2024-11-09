function closeModalsIsOpen () {
    const modals = document.querySelectorAll('.modal');

    modals.forEach(modal => {

        // Закрыть модальное окно при клике вне его области
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
                document.body.classList.remove('modal__open');
            }
        });
    });
}

export default closeModalsIsOpen;
