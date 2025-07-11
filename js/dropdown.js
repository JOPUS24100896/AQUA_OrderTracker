document.addEventListener("DOMContentLoaded", function () {
    const accountBtn = document.getElementById("accountBtn");
    const accountPopup = document.getElementById("accountPopup");

    accountBtn.addEventListener("click", function (event) {
        event.stopPropagation();
        accountPopup.classList.toggle("show");
    });

    document.addEventListener("click", function (event) {
        if (!accountPopup.contains(event.target) && event.target !== accountBtn) {
            accountPopup.classList.remove("show");
        }
    });
});