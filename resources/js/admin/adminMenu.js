import { WyswigElement } from './wyswigElement.js';


class adminMenu {
        
    constructor() {
        this.adminMenuElement = document.getElementById('adminMenu');
        this.wyswigElement = WyswigElement.create(undefined, null);
        this.init();
    }

    init() {
        this.bindEvents();
        this.hideOptions();
        this.hideTabscontent();
        this.addOptionsHandle();
        this.showOption('Logout');
        this.showOption('Zarządzanie plikami');
        this.showOption('Ustawienia Żylety');
    }

    bindEvents() {
        // Event delegation for menu items
        // document.querySelector('.adminMenu-container').addEventListener('click', (event) => {
        //     if (event.target.classList.contains('adminMenu-item')) {
        //         this.handleMenuClick(event);
        //     }
        // });

        // Context menu event
        document.addEventListener('contextmenu', (e) => this.handleContextMenu(e));

        // Click outside to hide menu
        document.addEventListener('click', (e) => this.handleDocumentClick(e));
    }

    handleMenuClick(event) {
        const target = event.target;
        const submenu = target.querySelector('.admin-submenu');

        if (submenu) {
            submenu.classList.toggle('active');
            event.stopPropagation();
        }
    }

    handleContextMenu(event) {
        event.preventDefault();
        if (this.adminMenuElement) {
            this.adminMenuElement.style.left = `${event.clientX}px`;
            this.adminMenuElement.style.top = `${event.clientY}px`;
            this.showadminMenu(event.target);

            let element = this.getWyswigTargetElement(event.target);
            if(element){
                this.wyswigElement = WyswigElement.create(element.element, element.type);
                
            }else{
                this.wyswigElement = undefined;
                this.hideOptions();
            }
            this.showOptions();
        }
    }

    handleDocumentClick(event) {
        if (this.adminMenuElement && !this.adminMenuElement.contains(event.target)) {
            this.hideadminMenu();
            this.hideTabscontent();
            this.CurrentChosenElement = undefined;
        }
    }

    showadminMenu() {
        if (this.adminMenuElement) {
            this.adminMenuElement.classList.add('visible');
        }
    }

    hideadminMenu() {
        if (this.adminMenuElement) {
            this.adminMenuElement.classList.remove('visible');
        }
    }

    getWyswigTargetElement(targetElement) {
        if (targetElement) {
            let type = targetElement.tagName;
            if (type == 'WYSWIGVARIABLE') {
                return {element: targetElement, type: type};
            } else {
                let tmptargetElement = targetElement;
                while (true) {
                    if (!tmptargetElement.parentElement) {
                        return undefined;
                    }
                    tmptargetElement = tmptargetElement.parentElement;
                    if (tmptargetElement.tagName == 'WYSWIGELEMENT' || tmptargetElement.tagName == 'WYSWIGCONTAINER') {
                        return {element: tmptargetElement, type: tmptargetElement.tagName};
                    }
                }
            }
        } else {
            return undefined;
        }
    }

    hideOptions(){
        let options = this.adminMenuElement.getElementsByClassName('adminMenuOptionMain');
        Array.from(options).forEach(option => {
            option.classList.add('hidden');
        });
        //show the default options
        this.showOption('Logout');
        this.showOption('Zarządzanie plikami');
        this.showOption('Ustawienia Żylety');
    }

    showOption(option){
        const targetOption = this.adminMenuElement.querySelector(`#${option}`);
        if (targetOption) {
            targetOption.parentElement.classList.remove('hidden');
        }
    }

    showOptions(){
        this.hideTabscontent();
        if (this.wyswigElement){
            console.log(this.wyswigElement.id);

            let options = this.wyswigElement.Options;
            Object.keys(options).forEach(label => {
                this.showOption(label);
                Object.keys(options[label]).forEach(optionsDetail => {
                    const button = document.createElement('button');
                    button.onclick = optionsDetail;
                    button.style = 'padding: 10px 25px;';
                    button.textContent = optionsDetail;
                    const targetElement = this.adminMenuElement.querySelector(`#${label}`);
                    if (targetElement) {
                        targetElement.appendChild(button);
                    }
                });
            });
        }
    }

    hideTabscontent(){
        let tabs = this.adminMenuElement.getElementsByClassName('tabcontent');
        Array.from(tabs).forEach(tab => {
            tab.innerHTML = ''; 
        });
    }

    addOptionsHandle(){
        this.adminMenuElement.querySelectorAll('.dropdownOptions').forEach((option) => {
            option.children[0].addEventListener('click', (event) => {
                option.children[0].classList.toggle('active');
                if (option.children[1].style.display === 'block') {
                    option.children[1].style.display = 'none';
                }
                else {
                    option.children[1].style.display = 'block';
                }
                let elements = this.adminMenuElement.querySelectorAll('.dropdownOptions');
                Array.from(elements).forEach((element) => {
                    if (element != option) {
                        element.children[1].style.display = 'none';
                    }
                });
            });
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.adminMenu = new adminMenu();
});

