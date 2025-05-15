import { WyswigElement } from './wyswigElement.js';
import { contextMenu } from './contextMenu.js';
import { wyswigEditor } from './wyswig.js';


class adminMenu extends contextMenu {
    init() {
        super.init?.();
    }

    handleContextMenu(event) {
        if (window.zarzadzaniePlikamiWindow.WindowElement.classList.contains('visible')){
            return;
        }
        super.handleContextMenu?.(event);
        this.showOptions();
    }

    handleDocumentClick(event) {
        if (!window.elementStyleSettingsWindow.WindowElement.classList.contains('visible')) {
            if (!window.zmienNazwePlikuForm.WindowElement.contains(event.target)) {
                super.handleDocumentClick?.(event);
            }
        }
    }

    showOptions() {
        this.clearDropdownOptionsContent();
        this.showDefaultOptions();
        if (this.targetElement) {
            let options = this.targetElement.Options;
            Object.keys(options).forEach(label => {
                this.showOption(label);
                Object.keys(options[label]).forEach(optionsDetail => {
                    const button = document.createElement('button');
                    button.onclick = button.onclick = options[label][optionsDetail];;
                    button.style = 'padding: 10px 25px;';
                    button.textContent = optionsDetail;
                    const targetElement = this.contextMenuElement.querySelector(`#${label}`);
                    if (targetElement) {
                        targetElement.appendChild(button);
                    }
                });
            });
            this.targetElement = undefined;
        }
    }

    getWyswigTargetElement(targetElement) {
        if (targetElement) {
            let type = targetElement.tagName;
            if (type == 'WYSWIGVARIABLE') {
                return {element: targetElement, type: type};
            } else if (targetElement.getAttribute('data-type') =='media'){
                return { element: targetElement, type: 'WYSWIGMEDIA' };
            }else {
                let tmptargetElement = targetElement;
                while (true) {
                    if (!tmptargetElement.parentElement) {
                        return undefined;
                    }
                    if (tmptargetElement.tagName == 'WYSWIGELEMENT' || tmptargetElement.tagName == 'WYSWIGCONTAINER') {
                        return {element: tmptargetElement, type: tmptargetElement.tagName};
                    }
                    tmptargetElement = tmptargetElement.parentElement;
                }
            }
        } else {
            return undefined;
        }
    }

    getTargetElement(targetElement) {
        let element = this.getWyswigTargetElement(targetElement);
        if (element) {
            this.targetElement = WyswigElement.create(element.element, element.type);
        } else {
            this.targetElement = undefined;
        }
    }

}

document.addEventListener('DOMContentLoaded', () => {
    window.adminMenu = new adminMenu(document.getElementById('adminMenu'), ['Logout', 'ZarzadzaniePlikami', 'Ustawienia Żylety']);
    document.getElementById('saveWyswigButton').addEventListener("click", (e) =>{
        wyswigEditor.zapiszWyswig();
    });
});

