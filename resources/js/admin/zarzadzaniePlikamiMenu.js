import { contextMenu } from './contextMenu.js';

class zarzadzaniePlikamiMenu extends contextMenu {
    init() {
        super.init?.();
        this.changeNameForm = document.getElementById('changeNameForm');



        document.getElementById('kopiujLink').addEventListener('click', () => {
            this.kopiujLink();
        });
        document.getElementById('usunFolder').addEventListener('click', () => {
            this.usunFolder();
        });
        document.getElementById('dodajPliki').addEventListener('click', () => {
            this.dodajPliki();
        });
        document.getElementById('dodajFolder').addEventListener('click', () => {
            this.dodajFolder();
        });
        document.getElementById('zmienNazwe').addEventListener('click', () => {
            this.zmienNazwe();
        });
        document.getElementById('usunPlik').addEventListener('click', () => {
            this.usunPlik();
        });
    }

    handleContextMenu(event) {
        event.preventDefault();
        if (!window.zarzadzaniePlikamiWindow.WindowElement.classList.contains('visible')) {
            return;
        }
        if (window.zmienNazwePlikuForm.WindowElement.classList.contains('visible')){
            return;
        }
        super.handleContextMenu?.(event);
    }

    getTargetElement(targetElement) {
        if (targetElement.classList.contains('adminFileItem')) {
            this.targetElement = targetElement;
        } else if (targetElement.parentElement.classList.contains('adminFileItem')) {
            this.targetElement = targetElement.parentElement;
        } else if (targetElement.classList.contains('window')) {
            this.targetElement = targetElement;
        }
        else {
            this.targetElement = undefined;
        }
    }

    showcontextMenu() {
        if (this.targetElement) {
            if (this.targetElement.classList.contains('window')) {
                this.showOption('dodajFolder');
                this.showOption('dodajPliki');
                super.showcontextMenu?.();
            } else {
                if (this.targetElement.dataset.prev) {
                    this.hideOptions();
                    this.hideContextMenu();
                    return;
                }
                super.showcontextMenu?.();
                const path = this.targetElement.getAttribute('data-path');
                if (path.endsWith("\\") || path.endsWith("/")) {
                    this.showOption('usunFolder');
                    this.showOption('kopiujLink');
                    this.showOption('zmienNazwe');
                } else {
                    this.showOption('usunPlik');
                    this.showOption('kopiujLink');
                    this.showOption('zmienNazwe');
                }
            }
        }
    }

    kopiujLink() {
        navigator.clipboard.writeText(this.targetElement.getAttribute('data-path'));
        setTimeout(() => {
            this.hideContextMenu();
        }, 50);
    }

    usunFolder($path) {

    }

    usunPlik($path) {
        
    }

    dodajPliki() {

    }

    dodajFolder() {

    }

    zmienNazwe() {
        window.zmienNazwePlikuForm.WindowElement.querySelector('#currentName').value = this.targetElement.getAttribute('data-path');
        window.zmienNazwePlikuForm.WindowElement.querySelector('#newName').value = '';
        window.zmienNazwePlikuForm.showWindowElement();
    }
}


document.addEventListener('DOMContentLoaded', () => {
    window.zarzadzaniePlikamiMenu = new zarzadzaniePlikamiMenu(document.getElementById('zarzadzaniePlikamiMenu'));
});