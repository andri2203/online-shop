const showSidebar = document.getElementById("showSidebar");
const sidebar = document.getElementById("sidebar");

showSidebar.addEventListener("click", (e) => {
    e.preventDefault();

    sidebar.classList.toggle("unshow");
});

const userMenuButton = document.getElementById("user-menu-button");
const userMenuList = document.getElementById("user-menu-list");

if (userMenuButton && userMenuList) {
    userMenuButton.addEventListener("click", function (e) {
        e.preventDefault();

        userMenuList.classList.toggle("hidden");
    });
}
