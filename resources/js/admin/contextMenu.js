export class contextMenu{
    constructor(element, alwaysVisibleOptions = []){
        this.contextMenuElement = element;
        this.targetElement = undefined;
        this.alwaysVisibleOptions = alwaysVisibleOptions;
        this.init();
    }

    init(){
        this.bindEvents();
        this.hideOptions();
        this.clearDropdownOptionsContent();
        this.addDropdownOptionsHandle();
    }

    bindEvents() {
        document.addEventListener('contextmenu', (e) => this.handleContextMenu(e));

        document.addEventListener('click', (e) => this.handleDocumentClick(e));
    }

    handleContextMenu(event) {
        event.preventDefault();
        this.hideOptions();
        this.showDefaultOptions();
        this.closeOptionsDropdownAll();
        this.contextMenuElement.style.left = `${event.clientX}px`;
        this.contextMenuElement.style.top = `${event.clientY}px`;
        this.getTargetElement(event.target);
        this.showcontextMenu();
    }

    handleDocumentClick(event) {
        if (!this.contextMenuElement.contains(event.target)) {
            this.hideContextMenu();
            this.targetElement = undefined;
        }
    }

    /**
     * @abstract
     */
    getTargetElement(targetElement) {

    }

    showDefaultOptions() {
        this.alwaysVisibleOptions.forEach((option) => {
            this.showOption(option);
        });
    }

    showcontextMenu() {
        this.contextMenuElement.classList.add('visible');
    }

    hideContextMenu() {
        this.contextMenuElement.classList.remove('visible');
    }

    showOption(option) {
        const targetOption = this.contextMenuElement.querySelector(`#${option}`);
        if (targetOption) {
            targetOption.parentElement.classList.remove('hidden');
        }
    }

    hideOption(){
        const targetOption = this.contextMenuElement.querySelector(`#${option}`);
        if (targetOption) {
            targetOption.parentElement.classList.add('hidden');
        }
    }

    showOptions() {
        this.clearDropdownOptionsContent();
        this.showDefaultOptions();
        this.contextMenuElement.querySelectorAll('.contextMenuOption').forEach((option) => {
            option.classList.remove('hidden');
        });
    }

    hideOptions() {
        this.clearDropdownOptionsContent();
        let options = this.contextMenuElement.getElementsByClassName('contextMenuOption');
        Array.from(options).forEach(option => {
            option.classList.add('hidden');
        });
    }

    // clear lista dropdown
    clearDropdownOptionsContent() {
        let tabs = this.contextMenuElement.getElementsByClassName('tabcontent');
        Array.from(tabs).forEach(tab => {
            tab.innerHTML = '';
        });
    }

    closeOptionDropdown(option) {
        option.children[0].classList.remove('active');
        option.children[1].style.display = 'none';
    }

    closeOptionsDropdownAll() {
        this.contextMenuElement.querySelectorAll('.dropdownOptions').forEach((option) => {
            this.closeOptionDropdown(option);
        });
    }


    addDropdownOptionsHandle() {
        this.contextMenuElement.querySelectorAll('.dropdownOptions').forEach((option) => {
            option.children[0].addEventListener('click', () => {
                if (option.children[0].classList.contains('active')) {
                    this.closeOptionDropdown(option);
                } else {
                    this.openOptionsDropdown(option);
                }
            });
        });
    }

    openOptionsDropdown(option) {
        option.children[0].classList.add('active');
        option.children[1].style.display = 'block';
        //schowaj pozostałe opcje
        let elements = this.contextMenuElement.querySelectorAll('.dropdownOptions');
        Array.from(elements).forEach((element) => {
            if (element != option) {
                element.children[1].style.display = 'none';
            }
        });
    }
}
