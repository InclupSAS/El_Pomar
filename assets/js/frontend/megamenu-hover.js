document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.main-menu .menu-list > li.menu-item');
    const megamenuContainers = document.querySelectorAll('.megamenu-container .megamenu');
    const megamenuWrapper = document.querySelector('.megamenu-container'); 

    let lastThumbnailUrl = '';

    function showMegamenu(megamenu) {

        megamenuWrapper.style.display = 'block';

        megamenuContainers.forEach(container => {
            container.style.display = 'none';
        });
        megamenu.style.display = 'flex';

        const thumbnailMenu = megamenu.querySelector('.thumbnail-menu');
        const firstSubmenuItem = megamenu.querySelector('.submenu .menu-item');
        if (firstSubmenuItem && thumbnailMenu) {
            const firstThumbnail = firstSubmenuItem.querySelector('.menu-item-thumbnail');
            if (firstThumbnail) {
                const firstThumbnailUrl = firstThumbnail.getAttribute('src');
                thumbnailMenu.style.backgroundImage = `url(${firstThumbnailUrl})`;
                lastThumbnailUrl = firstThumbnailUrl;
            }
        }
    }

    function hideMegamenu() {
        megamenuContainers.forEach(container => {
            container.style.display = 'none';
        });
        megamenuWrapper.style.display = 'none';
    }

    function isCursorOverMenu() {
        const overMenuItem = Array.from(menuItems).some(item => item.matches(':hover'));
        const overMegamenu = megamenuWrapper.matches(':hover');
        return overMenuItem || overMegamenu;
    }

    menuItems.forEach(item => {
        const itemId = item.id.replace('menu-item-', '');
        const megamenu = document.getElementById('megamenu-' + itemId);

        if (megamenu) {
            item.addEventListener('mouseenter', function() {
                showMegamenu(megamenu);
            });
        }
    });

    document.addEventListener('mousemove', function() {
        if (!isCursorOverMenu()) {
            hideMegamenu();
        }
    });

    const submenuItems = document.querySelectorAll('.megamenu .submenu .menu-item');

    submenuItems.forEach(item => {
        const thumbnail = item.querySelector('.menu-item-thumbnail');
        const thumbnailMenu = item.closest('.megamenu').querySelector('.thumbnail-menu');

        if (thumbnail && thumbnailMenu) {
            item.addEventListener('mouseenter', function() {
                const thumbnailUrl = thumbnail.getAttribute('src');
                thumbnailMenu.style.backgroundImage = `url(${thumbnailUrl})`;
                lastThumbnailUrl = thumbnailUrl;
            });

            item.addEventListener('mouseleave', function() {
                thumbnailMenu.style.backgroundImage = `url(${lastThumbnailUrl})`;
            });
        }
    });
});