document.addEventListener("DOMContentLoaded", function () {
    // Submenu toggle
    document.querySelectorAll(".has-submenu > .sidebar-link").forEach(trigger => {
        trigger.addEventListener("click", function (e) {
            e.preventDefault();
            const parentGroup = this.closest(".sidebar-group");
            const submenu = parentGroup.querySelector(".submenu");

            document.querySelectorAll(".custom-sidebar-menu .submenu").forEach(menu => {
                if (menu !== submenu) menu.classList.remove("active");
            });
            document.querySelectorAll(".has-submenu > .sidebar-link").forEach(link => {
                if (link !== this) link.classList.remove("active");
            });

            submenu.classList.toggle("active");
            this.classList.toggle("active");
        });
    });

    // Sub-submenu toggle
    document.querySelectorAll(".has-sub-submenu > .submenu-link").forEach(trigger => {
        trigger.addEventListener("click", function (e) {
            e.preventDefault();
            const parentItem = this.closest(".submenu-item");
            const subSubmenu = parentItem.querySelector(".sub-submenu");

            parentItem.parentElement.querySelectorAll(".sub-submenu").forEach(menu => {
                if (menu !== subSubmenu) menu.classList.remove("active");
            });
            parentItem.parentElement.querySelectorAll(".submenu-link").forEach(link => {
                if (link !== this) link.classList.remove("active");
            });

            subSubmenu.classList.toggle("active");
            this.classList.toggle("active");
        });
    });
});