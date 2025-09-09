document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll(".tabs li");
    const contents = document.querySelectorAll(".tabs_item");

    tabs.forEach(tab => {
        tab.addEventListener("click", () => {
            let tabId = tab.getAttribute("data-tab");

            contents.forEach(c => c.style.display = "none");
            tabs.forEach(t => t.classList.remove("active"));

            document.getElementById(tabId).style.display = "block";
            tab.classList.add("active");
        });
    });

    if (contents.length > 0) {
        contents.forEach((c, i) => c.style.display = i === 0 ? "block" : "none");
        tabs[0].classList.add("active");
    }
});
