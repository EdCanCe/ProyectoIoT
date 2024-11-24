document.addEventListener('DOMContentLoaded', () => {
    const dropdowns = document.querySelectorAll('.dropdown');

    dropdowns.forEach(dropdown => {
        const select = dropdown.querySelector('.select');
        const selected = dropdown.querySelector('.selected');
        const caret = dropdown.querySelector('.caret');
        const menu = dropdown.querySelector('.menu');
        const options = dropdown.querySelectorAll('.menu a');

        // Recuperar la selección desde Local Storage (si existe)
        const savedSelection = localStorage.getItem('selectedRoom');
        if (savedSelection) {
            selected.innerText = savedSelection;
            options.forEach(option => {
                option.classList.remove('active');
                if (option.innerText === savedSelection) {
                    option.classList.add('active');
                }
            });
        }

        select.addEventListener('click', () => {
            select.classList.toggle('select-clicked');
            caret.classList.toggle('caret-rotate');
            menu.classList.toggle('menu-open');
        });

        options.forEach(option => {
            option.addEventListener('click', (e) => {
                e.preventDefault(); // Evita el redireccionamiento inmediato
                const selectedRoom = option.innerText;

                // Guardar la selección en Local Storage
                localStorage.setItem('selectedRoom', selectedRoom);

                selected.innerText = selectedRoom;
                select.classList.remove('select-clicked');
                caret.classList.remove('caret-rotate');
                menu.classList.remove('menu-open');

                options.forEach(option => option.classList.remove('active'));
                option.classList.add('active');

                // Redirigir después de guardar la selección
                window.location.href = option.href;
            });
        });
    });
});
