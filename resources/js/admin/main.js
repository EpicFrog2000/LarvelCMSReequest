const adminMenu = document.getElementById("adminMenu");
const UstawieniaElementuOption = adminMenu.querySelector('[id="Ustawienia Elementu"]');
window.CurrentChosenElement = undefined;

function hideAdminMenu() {
    adminMenu.classList.remove("visible");
    clearTabs();
}

function showAdminMenu(targetElement) {
    GetWyswigTargetElement(targetElement);
    clearTabs();
    if(window.CurrentChosenElement){
        UstawieniaElementuOption.style.display = 'block';
    }else{
        UstawieniaElementuOption.style.display = 'none';
    }
    adminMenu.classList.add("visible");
}

function GetWyswigTargetElement(targetElement){
    if (targetElement) {
        console.log(targetElement);
        let type = targetElement.tagName;
        if(type == 'WYSWIGVARIABLE'){
            window.CurrentChosenElement = targetElement;
            return;
        }else{
            let tmptargetElement = targetElement;
            while(true){
                if(!tmptargetElement.parentElement){
                    window.CurrentChosenElement = undefined;
                    return;
                }
                tmptargetElement = tmptargetElement.parentElement;
                if(tmptargetElement.tagName == 'WYSWIGELEMENT'  || tmptargetElement.tagName == 'WYSWIGCONTAINER'){
                    window.CurrentChosenElement = tmptargetElement;
                    return;
                }
            }
        }
    }else{
        window.CurrentChosenElement = undefined;
        return;
    }
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