$(document).ready(function () {
    $(document).on('click', '#active-sidebar', function (e) {
        e.preventDefault();
        $('.main-sidebar').toggleClass('active');
        $('.main-header').toggleClass('active');
    });

    $(document).on('click', '.nav-item.dropdown>.nav-link', function (e) {
        e.preventDefault();
        const dropdown = $(this).parent();
        dropdown.find('.dropdown-menu.dropdown-menu-lg.dropdown-menu-right').toggleClass('show');
    });
})