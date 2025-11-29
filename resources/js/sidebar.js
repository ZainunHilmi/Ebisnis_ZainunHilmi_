document.addEventListener('DOMContentLoaded', function () {
    var sidebar = document.querySelector('.sidebar');
    var toggle = document.querySelector('.toggle');
    var sidebarItems = document.querySelectorAll('.sidebar-item');

    toggle.addEventListener('click', function () {
        sidebar.classList.toggle('collapsed');
    });

    sidebarItems.forEach(function (item) {
        item.addEventListener('click', function () {
            sidebar.classList.remove('collapsed');
        });
    });
});