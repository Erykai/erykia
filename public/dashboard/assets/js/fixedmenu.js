function initializeMenu(menuId, hasSubmenu = true) {
    const parentMenu = hasSubmenu ? document.querySelector(`div[data-menu-id="${menuId}"]`) : null;
    const menuItemLinks = document.querySelectorAll(`a[data-menu-id="${menuId}"]`);

    function closeOtherMenusAndRemoveActiveClass(currentMenuId) {
        const otherParentMenus = document.querySelectorAll(`div[data-menu-id]:not([data-menu-id="${currentMenuId}"])`);
        const otherMenuItemLinks = document.querySelectorAll(`a[data-menu-id]:not([data-menu-id="${currentMenuId}"])`);

        otherParentMenus.forEach(menu => {
            menu.classList.remove('show');
        });

        otherMenuItemLinks.forEach(link => {
            link.classList.remove('active');
            localStorage.removeItem(`${link.dataset.menuId}-lastClickedMenuItem`);
        });
    }

    function onMenuItemClick(event) {
        closeOtherMenusAndRemoveActiveClass(menuId);

        localStorage.setItem(`${menuId}-lastClickedMenuItem`, event.target.href);

        menuItemLinks.forEach(link => {
            link.classList.remove('active');
        });

        event.target.classList.add('active');
        if (hasSubmenu && parentMenu) {
            parentMenu.classList.add('show');
        }
    }

    menuItemLinks.forEach(link => {
        link.addEventListener('click', onMenuItemClick);
    });

    const lastClickedMenuItemHref = localStorage.getItem(`${menuId}-lastClickedMenuItem`);

    if (lastClickedMenuItemHref) {
        const lastClickedMenuItem = [...menuItemLinks].find(link => link.href === lastClickedMenuItemHref);

        if (lastClickedMenuItem) {
            if (hasSubmenu && parentMenu) {
                parentMenu.classList.add('show');
            }
            lastClickedMenuItem.classList.add('active');
        }
    }
}
