import { defaultWindow } from './defaultWindow.js';


class elementStyleSettingsWindow extends defaultWindow {
    init() {
        super.init?.();

        let layout_options_buttons = new buttonsOption('layout-options-buttons', 'display', this.WindowElement);
        let flex_direction = new selectOption('flex-direction', 'flex-direction', this.WindowElement);
        let column_y = new selectOption('column-y', 'justify-content', this.WindowElement);
        let column_x = new selectOption('column-x', 'align-items', this.WindowElement);
        let row_x = new selectOption('row-x', 'align-items', this.WindowElement);
        let row_y = new selectOption('row-x', 'justify-content', this.WindowElement);
        let grid_x = new selectOption('grid-x', 'justify-items', this.WindowElement);
        let grid_y = new selectOption('grid-y', 'align-items', this.WindowElement);
        let flex_c_gap_columns = new inputOption('column-gap-columns', 'grid-column-gap', this.WindowElement);
        let flex_c_gap_rows = new inputOption('column-gap-rows', 'grid-row-gap', this.WindowElement);
        let flex_r_gap_columns = new inputOption('row-gap-columns', 'grid-column-gap', this.WindowElement);
        let flex_r_gap_rows = new inputOption('row-gap-rows', 'grid-row-gap', this.WindowElement);
        function handleColumsChange(value) {
            value = parseInt(value);
            if (value < 1) return;
            const val = Array(value).fill('1fr').join(' ');
            window.elementStyleSettingsWindow.changeProperty('grid-template-columns', val);
        }
        let grid_columns = new customInputOption('columnsInput', 'grid-template-columns', this.WindowElement, handleColumsChange);
        function handleRowsChange(value) {
            value = parseInt(value);
            if (value < 1) return;
            const val = Array(value).fill('1fr').join(' ');
            window.elementStyleSettingsWindow.changeProperty('grid-template-rows', val);
        }
        let grid_rows = new customInputOption('rowsInput', 'grid-template-rows', this.WindowElement, handleRowsChange);
        let grid_flow = new selectOption('grid-direction', 'grid-auto-flow', this.WindowElement);
        let grid_gap_columns = new inputOption('grid-gap-columns', 'grid-column-gap', this.WindowElement);
        let grid_gap_rows = new inputOption('grid-gap-rows', 'grid-row-gap', this.WindowElement);

        let margin_left = new inputOption('margin-left', 'margin-left', this.WindowElement);
        let margin_right = new inputOption('margin-right', 'margin-right', this.WindowElement);
        let margin_top = new inputOption('margin-top', 'margin-top', this.WindowElement);
        let margin_bottom = new inputOption('margin-bottom', 'margin-bottom', this.WindowElement);
        let padding_left = new inputOption('padding-left', 'padding-left', this.WindowElement);
        let padding_right = new inputOption('padding-right', 'padding-right', this.WindowElement);
        let padding_top = new inputOption('padding-top', 'padding-top', this.WindowElement);
        let padding_bottom = new inputOption('padding-bottom', 'padding-bottom', this.WindowElement);


        // TODO add the rest
        // ależ kurwa mam głód alkocholowy :cccccc


        this.options = [layout_options_buttons, flex_direction, column_y, column_x, row_x, row_y, grid_x, grid_y, grid_columns, grid_rows]; // TODO add the rest

        this.initTabswithButtons('layout-options-buttons', 'layout-tabs-content', [flex_direction]);
        this.initTabswithSelect('flex-direction', 'flex-direction-tabs-content', [column_y, column_x, row_x, row_y, grid_x, grid_y, flex_c_gap_columns, flex_c_gap_rows, flex_r_gap_columns, flex_r_gap_rows , grid_columns, grid_rows, grid_flow, grid_gap_columns, grid_gap_rows]);
    
    }

    showWindowElement(){
        super.showWindowElement?.();

    }

    defaultAllOptions(){
        this.options.forEach(option => {
            option.setDefaultValues();
        });
    }

    changeProperty(property, value) {
        if (property in this.element.style) {
            this.element.style[property] = value;
        } else {
            console.warn(`Nieprawidłowa właściwość CSS: ${property}, pobij Norberta ;P`);
        }
    }

    showWindowElement(element){
        this.setTargetElement(element);
        super.showWindowElement?.();
    }

    setTargetElement(element){
        this.element = element;
    }

    initTabswithButtons(buttons_container_id, tabs_container_id, options_to_reset){
        const buttons = document.getElementById(buttons_container_id).children;
        const tabs = document.getElementById(tabs_container_id).children;
        Array.from(buttons).forEach(button => {
            button.addEventListener('click', () => {
                button.classList.add('selected');
                Array.from(buttons).forEach(btn => {
                    if(btn != button){
                        btn.classList.remove('selected');
                    }
                });
                let chosen_tab = document.getElementById(button.id.split('-')[0] + "-tab");
                options_to_reset.forEach(option => {
                    option.setDefaultValues();
                });
                chosen_tab.classList.add('visible');
                Array.from(tabs).forEach(tab => {
                    if(tab != chosen_tab){
                        tab.classList.remove('visible');
                    }
                });
            });
        });
        // by default select first tab
        buttons[0].classList.add('selected');
        tabs[0].classList.add('visible');
        options_to_reset.forEach(option => {
            option.setVisualDefaultValues();
        });
    }

    initTabswithSelect(select_element_id, tabs_container_id, options_to_reset){
        const select_element = document.getElementById(select_element_id);
        const tabs = document.getElementById(tabs_container_id).children;
        select_element.addEventListener("change", function () {
            const selectedValue = this.value;
            let chosen_tab = document.getElementById(selectedValue.split('-')[0] + "-tab");
            chosen_tab.classList.add('visible');
            options_to_reset.forEach(option => {
                option.setDefaultValues();
            });
            Array.from(tabs).forEach(tab => {
                if(tab != chosen_tab){
                    tab.classList.remove('visible');
                }
            });
        });
        tabs[0].classList.add('visible');
        options_to_reset.forEach(option => {
            option.setVisualDefaultValues();
        });
    }
}

class selectOption{
    constructor(elementId, styleName, WindowElement) {
        this.SettingsWindowElement = WindowElement;
        this.element = this.SettingsWindowElement.querySelector(`#${elementId}`);
        this.styleName = styleName;
        this.init();
    }

    init(){
        this.element.addEventListener("change", () => {
            window.elementStyleSettingsWindow.changeProperty(this.styleName, this.element.value);
        });
    }

    setDefaultValues(){
        this.element.value = this.element.options[0].value;
        window.elementStyleSettingsWindow.changeProperty(this.styleName, this.element.value);
    }

    setVisualDefaultValues(){
        this.element.value = this.element.options[0].value;
    }

    setValue(value){
        this.element.value = value;
    }
}

class buttonsOption{
    constructor(buttonscontainerId, styleName, WindowElement) {
        this.SettingsWindowElement = WindowElement;
        this.buttonscontainer = this.SettingsWindowElement.querySelector(`#${buttonscontainerId}`);
        this.styleName = styleName;
        this.init();
    }

    init(){
        Array.from(this.buttonscontainer.children).forEach(button => {
            button.addEventListener("click", () => {
                window.elementStyleSettingsWindow.changeProperty(this.styleName, button.value);
            });
        });
    }

    setDefaultValues(){
        this.buttonscontainer.children.forEach(button => {
            button.classList.remove('selected');
        });
        this.buttonscontainer.children[0].classList.add('selected');
        window.elementStyleSettingsWindow.changeProperty(this.styleName, this.buttonscontainer.children[0].value);
    }

    setVisualDefaultValues(){
        this.buttonscontainer.children.forEach(button => {
            button.classList.remove('selected');
        });
        this.buttonscontainer.children[0].classList.add('selected');
    }

    setValue(id, value){
        this.buttonscontainer.getElementById(id).value = value;
    }
}

class inputOption{
    constructor(elementId, styleName, WindowElement) {
        this.SettingsWindowElement = WindowElement;
        this.element = this.SettingsWindowElement.querySelector(`#${elementId}`);
        this.styleName = styleName;
        this.init();
    }

    init(){
        this.element.addEventListener("input", () => {
            if(this.element.type=="text"){
                const value = this.element.value.trim();
                if (this.isValidCssSize(value) || value == "auto") {
                    window.elementStyleSettingsWindow.changeProperty(this.styleName, value);
                    this.element.style.borderColor = '';
                } else {
                    this.element.style.borderColor = 'red';
                }
            }
        });
    }

    setDefaultValues(){
        this.element.value = this.element.placeholder;
        window.elementStyleSettingsWindow.changeProperty(this.styleName, this.element.value);
    }

    setVisualDefaultValues(){
        this.element.value = this.element.placeholder;
    }

    setValue(value){
        this.element.value = value;
    }

    isValidCssSize(value) {
        return /^-?\d+(\.\d+)?(px|em|rem|%|vw|vh|fr|ch|ex|vmin|vmax)$/.test(value.trim());
    }
}

class customInputOption{
    constructor(elementId, styleName, WindowElement, customHandleFunction) {
        this.SettingsWindowElement = WindowElement;
        this.element = this.SettingsWindowElement.querySelector(`#${elementId}`);
        this.styleName = styleName;
        this.customHandleFunction = customHandleFunction;
        this.init();
    }

    init(){
        this.element.addEventListener("input", () => {
            this.customHandleFunction(this.element.value);
        });
    }

    setDefaultValues(){
        this.element.value = this.element.placeholder;
        window.elementStyleSettingsWindow.changeProperty(this.styleName, this.element.value);
    }

    setVisualDefaultValues(){
        this.element.value = this.element.placeholder;
    }

    setValue(value){
        this.element.value = value;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.elementStyleSettingsWindow = new elementStyleSettingsWindow(document.getElementById('elementStyleSettingsWindow'));
});

// TODO trzeba bedzie zrobić jsona z wartościami do bazy xdd
// i potem setdefaultvalues na values z tego jsona omgggggg, ale kurwa roboty, potrzebuje piwa...
// TODO możę nie zamykaj jak coś prubuje zaznaczyć xdddddd

// TODO może zmienić te window.sth na export const, to bedzie lepsze xdd
// TODO zgub focus jeśli zamykane są okeinka
// o ja jeba ale jest kurwa roboty w pizdu
// zesram sieeeeee

//TODO wymyślić jak zrobić klasy w elementach takie jak w webflow i aby współgrały ze statycznymi elementami