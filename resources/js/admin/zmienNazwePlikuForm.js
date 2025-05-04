import { defaultWindow } from './defaultWindow.js';

class zmienNazwePlikuForm extends defaultWindow {
    init() {   
        super.init?.();
        window.zarzadzaniePlikamiMenu
    }

    showWindowElement() {
        super.showWindowElement?.();
        window.zarzadzaniePlikamiMenu.hideContextMenu();
    }
}


document.addEventListener('DOMContentLoaded', () => {
    window.zmienNazwePlikuForm = new zmienNazwePlikuForm(document.getElementById('zmienNazwePlikuForm'));
});