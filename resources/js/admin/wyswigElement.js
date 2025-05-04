export class WyswigElement {
    constructor(element = undefined, type = null) {
        this.element = element;
        this.type = type;
        if (element && element.getAttribute('data-id') == null) {
            let parent = this.getParentElement();
            this.id = parent.getAttribute('data-id');
        }
        this.init();
    }

    init() {
        
    }

    static create(element = undefined, type = null) {
        switch (type) {
            case 'WYSWIGELEMENT':
                return new wyswigElement(element, type);
            case 'WYSWIGVARIABLE':
                return new wyswigVariable(element, type);
            case 'WYSWIGCONTAINER':
                return new wyswigContainer(element, type);
            case 'WYSWIGMEDIA':
                return new wyswigMedia(element, type);
            default:
                return new WyswigElement(element, type);
        }
    }
}

class wyswigVariable extends WyswigElement {
    init() {
        this.Options = {
            'UstawieniaElementu': {
                'Usuń element': this.remove.bind(this),
                'Edytuj styl': this.editStyle.bind(this)
            },
        };
    }

    getParentElement() {
        let parentElement = this.element?.parentElement;
        while (parentElement) {
            if (['WYSWIGCONTAINER', 'WYSWIGELEMENT'].includes(parentElement.tagName)) {
                return parentElement;
            }
            parentElement = parentElement.parentElement;
        }
        return null;
    }

    editStyle() {
        
    }

    remove() {
        this.element?.remove();
    }
}

class wyswigElement extends WyswigElement {
    init() {
        this.Options = {
            'UstawieniaElementu': {
                'Usuń element': this.remove.bind(this),
                'Edytuj styl': this.editStyle.bind(this)
            },
        };
    }

    remove() {
        this.element?.remove();
    }

    getParentElement() {
        let parentElement = this.element?.parentElement;
        while (parentElement) {
            if (parentElement.tagName === 'WYSWIGCONTAINER') {
                return parentElement;
            }
            parentElement = parentElement.parentElement;
        }
        return null;
    }

    editStyle() {

    }
}

class wyswigContainer extends WyswigElement {
    init() {
        this.Options = {
            'UstawieniaElementu': {
                'Usuń element': this.remove.bind(this),
                'Edytuj styl': this.editStyle.bind(this)
            },
        };
    }

    remove() {
        this.element?.remove();
    }

    getParentElement() {
        let parentElement = this.element?.parentElement;
        while (parentElement) {
            if (parentElement.tagName === 'WYSWIGCONTAINER') {
                return parentElement;
            }
            parentElement = parentElement.parentElement;
        }
        return null;
    }

    editStyle() {

    }
}

class wyswigMedia extends WyswigElement {
    init() {
        this.Options = {
            'UstawieniaElementu': {
                'Usuń element': this.remove.bind(this),
                'Edytuj styl': this.editStyle.bind(this)
            },
        };
    }

    getParentElement() {
        let parentElement = this.element?.parentElement;
        while (parentElement) {
            if (['WYSWIGCONTAINER', 'WYSWIGELEMENT'].includes(parentElement.tagName)) {
                return parentElement;
            }
            parentElement = parentElement.parentElement;
        }
        return null;
    }

    editStyle() {

    }

    remove() {
        this.element?.remove();
    }
}
//Elementy tekstowe
//Elementy multimedialne
//Elementy kontenerowe
//Elementy customowe ???