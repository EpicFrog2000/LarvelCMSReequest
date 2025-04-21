const adminMenu = document.getElementById("adminMenu");
const wyswigPanels = document.getElementsByTagName("wyswigPanel");

function hideAdminMenu() {
    adminMenu.classList.remove("visible");
}

function showAdminMenu(targetElement) {
    if (targetElement) {
        if (targetElement.classList.contains("wyswig")) {
            console.log('wyswig');
        }
    }
    adminMenu.classList.add("visible");
}

function toggleAdminMenu() {
    adminMenu.classList.toggle("visible");
}

document.addEventListener("contextmenu", (e) => {
    e.preventDefault();
    adminMenu.style.left = `${e.clientX}px`;
    adminMenu.style.top = `${e.clientY}px`;
    showAdminMenu(e.target);
});

document.addEventListener("click", (e) => {
    if (!adminMenu.contains(e.target)) {
        hideAdminMenu();
    }
});

Array.from(wyswigPanels).forEach((element) => {
    const button = document.createElement("button");
    button.textContent = "+";
    button.classList.add("wyswigpanelbutton");
    button.onclick = () => {
        console.log("Button clicked in:", element);
    };

    element.appendChild(button);
});

