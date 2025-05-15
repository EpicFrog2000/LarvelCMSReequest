import { wyswigEditor } from './wyswig.js';
// z tego edytora brać metody

export class WyswigElement {
    constructor(element = undefined, type = null) {
        if (new.target === WyswigElement) {
            throw new Error("Nie można tworzyć instancji klasy abstrakcyjnej WyswigElement");
        }
        this.element = element;
        this.type = type;
        this.parentElement = this.getParentElement();
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

    getParentElement() {

    }

    getWyswigElementId(element){
        return element.getAttribute('data-id');
    }
}

class wyswigVariable extends WyswigElement {
    init() {
        this.Options = {
            'UstawieniaElementu': {
                'Usuń element': this.remove.bind(this), //Usuwa wyswigElement w którym ten Variable się znajduje
                'Edytuj styl': this.editStyle.bind(this), //edytuje styl parenta czyli wyswigElement lub wyswigContainer
                'Edytuj tekst': this.editText.bind(this),
                'Dodaj Kontenter': this.addContainer.bind(this), // Dodaje pod tym elementem nowy kontener
                'Dodaj Element': this.addElement.bind(this), // Dodaje pod tym elementem nowy element
                'Move Element': this.moveElement.bind(this), // Pokazuje  może okienko do ruszania elementem parenta?
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
        window.elementStyleSettingsWindow.showWindowElement(this.element);
        window.adminMenu.hideContextMenu();
    }

    remove() {
        let id = this.getWyswigElementId(this.parentElement);
        if(!id){
            alert('Nie znaleziono id elementu, idź i pobij Norberta');
        }
        this.parentElement?.parentNode?.removeChild(this.parentElement);
        window.adminMenu.hideContextMenu();
    }

    editText() {

    }

    addContainer(){

    }

    addElement(){

    }

    moveElement(){

    }
}

class wyswigElement extends WyswigElement {
    init() {
        this.Options = {
            'UstawieniaElementu': {
                'Usuń element': this.remove.bind(this), //Usuwa ten element
                'Edytuj styl': this.editStyle.bind(this), //edytuje styl parenta czyli wyswigElement lub wyswigContainer
                'Dodaj Kontenter': this.addContainer.bind(this), // Dodaje pod tym elementem nowy kontener
                'Dodaj Element': this.addElement.bind(this), // Dodaje pod tym elementem nowy element
                'Move Element': this.moveElement.bind(this), // Pokazuje  może okienko do ruszania elementem?
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
        window.elementStyleSettingsWindow.showWindowElement(this.element);
        window.adminMenu.hideContextMenu();
    }

    remove() {

    }

    addContainer(){

    }

    addElement(){

    }

    moveElement(){
        
    }
}

class wyswigContainer extends WyswigElement {
    init() {
        this.Options = {
            'UstawieniaElementu': {
                'Usuń element': this.remove.bind(this), //Usuwa ten element
                'Edytuj styl': this.editStyle.bind(this), //edytuje styl tego elementu
                'Dodaj Kontenter w': this.addContainerIn.bind(this), // Dodaje w tym elementem nowy kontener
                'Dodaj Kontenter pod': this.addContainer.bind(this), // Dodaje pod tym elementem nowy kontener
                'Dodaj Element w': this.addElementIn.bind(this), // Dodaje w tym elementem nowy element
                'Dodaj Element pod': this.addElement.bind(this), // Dodaje pod tym elementem nowy element
                'Move Element': this.moveElement.bind(this), // Pokazuje może okienko do ruszania elementem?
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
        window.elementStyleSettingsWindow.showWindowElement(this.element);
        window.adminMenu.hideContextMenu();
    }

    remove() {

    }

    addContainer(){

    }

    addContainerIn(){

    }

    addElement(){

    }

    addElementIn(){

    }

    moveElement(){
        
    }
}

class wyswigMedia extends WyswigElement {
    init() {
        this.Options = {
            'UstawieniaElementu': {
                'Usuń element': this.remove.bind(this), //Usuwa wyswigElement w którym ten Variable się znajduje
                'Edytuj styl': this.editStyle.bind(this), //edytuje styl parenta czyli wyswigElement lub wyswigContainer
                // TODO 'Ustawienia nwm to jest link obraz alt czy inne gówna': this.editText.bind(this),
                'Dodaj Kontenter': this.addContainer.bind(this), // Dodaje pod tym elementem nowy kontener
                'Dodaj Element': this.addElement.bind(this), // Dodaje pod tym elementem nowy element
                'Move Element': this.moveElement.bind(this), // Pokazuje  może okienko do ruszania elementem parenta?
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
        window.elementStyleSettingsWindow.showWindowElement(this.element);
        window.adminMenu.hideContextMenu();
    }

    remove() {

    }

    addContainer(){

    }

    addElement(){

    }

    moveElement(){
        
    }
}

//Elementy tekstowe
//Elementy multimedialne
//Elementy kontenerowe
//Elementy customowe ???
// bla bla bla