document.addEventListener('DOMContentLoaded', function() {
    const interactionSelects = document.querySelectorAll('.menu-interaction-select');

    function handleMegamenuOptionsVisibility(select) {
        const itemId = select.getAttribute('data-item-id');
        const megamenuOptions = document.getElementById('megamenu-options-' + itemId);
        const customContent = document.getElementById('custom-content-' + itemId);
        const submenuOptions = document.getElementById('submenu-options-' + itemId);
        const radioCustom = document.querySelector(`input[name="el_pomar_megamenu_type[${itemId}]"][value="custom"]`);
        const radioSubmenus = document.querySelector(`input[name="el_pomar_megamenu_type[${itemId}]"][value="submenus"]`);


        if (select.value === 'megamenu') {
            megamenuOptions.style.display = 'block';
            

            if (radioSubmenus && radioSubmenus.checked) {
                customContent.style.display = 'none';
                submenuOptions.style.display = 'block';
            } else if (radioCustom && radioCustom.checked) {
                customContent.style.display = 'block';
                submenuOptions.style.display = 'none';
            }
        } else {
            megamenuOptions.style.display = 'none';
        }
    }


    interactionSelects.forEach(select => {
        select.addEventListener('change', function() {
            handleMegamenuOptionsVisibility(this);
        });

        handleMegamenuOptionsVisibility(select);
    });


    const megamenuTypeRadios = document.querySelectorAll('input[name^="el_pomar_megamenu_type"]');
    megamenuTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const itemId = this.name.match(/\d+/)[0];
            const customContent = document.getElementById('custom-content-' + itemId);
            const submenuOptions = document.getElementById('submenu-options-' + itemId);
            
            if (this.value === 'custom') {
                customContent.style.display = 'block';
                submenuOptions.style.display = 'none';
            } else {
                customContent.style.display = 'none';
                submenuOptions.style.display = 'block';
            }
        });
    });

    interactionSelects.forEach(select => {
        handleMegamenuOptionsVisibility(select);
    });
});