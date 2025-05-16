export class defaultWindow {
    constructor(element) {
        this.WindowElement = element;
        this.init();
    }

    init() {
        this.bindEvents();
    }

    bindEvents() {
        //document.addEventListener('click', (e) => this.handleDocumentClick(e));

        // lepsze click xd
        let mouseDownTarget;
        document.addEventListener('mousedown', (e) => {
            mouseDownTarget = e.target;
        });

        document.addEventListener('click', (e) => {
            if (mouseDownTarget === e.target) {
                this.handleDocumentClick(e);
            }
            mouseDownTarget = null;
        });
    }

    // TODO meh
    handleDocumentClick(event) {
        if (!this.WindowElement.contains(event.target)
            && !window.adminMenu.contextMenuElement.contains(event.target)
            && !window.zarzadzaniePlikamiMenu.contextMenuElement.contains(event.target)) {
            this.hideWindowElement();
        }
    }

    showWindowElement() {
        this.WindowElement.classList.add('visible');
    }

    hideWindowElement() {
        this.WindowElement.classList.remove('visible');
    }

}