import { defaultWindow } from './defaultWindow.js';


class elementStyleSettingsWindow extends defaultWindow {
    init() {
        super.init?.();
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

document.addEventListener('DOMContentLoaded', () => {
    window.elementStyleSettingsWindow = new elementStyleSettingsWindow(document.getElementById('elementStyleSettingsWindow'));


    //jakoś inaczej trzeba bedzie to zdefiniować bo kurwa gówno
    class selectOption{
        constructor(elementId, styleName) {
            this.element = window.elementStyleSettingsWindow.WindowElement.querySelector(`#${elementId}`);
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
        constructor(buttonscontainerId, styleName) {
            this.buttonscontainer = window.elementStyleSettingsWindow.WindowElement.querySelector(`#${buttonscontainerId}`);
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
        constructor(elementId, styleName) {
            this.element = window.elementStyleSettingsWindow.WindowElement.querySelector(`#${elementId}`);
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
        constructor(elementId, styleName, customHandleFunction) {
            this.element = window.elementStyleSettingsWindow.WindowElement.querySelector(`#${elementId}`);
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

    let layout_options_buttons = new buttonsOption('layout-options-buttons', 'display');
    let flex_direction = new selectOption('flex-direction', 'flex-direction');
    let column_y = new selectOption('column-y', 'justify-content');
    let column_x = new selectOption('column-x', 'align-items');
    let row_x = new selectOption('row-x', 'align-items');
    let row_y = new selectOption('row-x', 'justify-content');
    let grid_x = new selectOption('grid-x', 'justify-items');
    let grid_y = new selectOption('grid-y', 'align-items');
    let flex_c_gap_columns = new inputOption('column-gap-columns', 'grid-column-gap');
    let flex_c_gap_rows = new inputOption('column-gap-rows', 'grid-row-gap');
    let flex_r_gap_columns = new inputOption('row-gap-columns', 'grid-column-gap');
    let flex_r_gap_rows = new inputOption('row-gap-rows', 'grid-row-gap');
    function handleColumsChange(value) {
        value = parseInt(value);
        if (value < 1) return;
        const val = Array(value).fill('1fr').join(' ');
        window.elementStyleSettingsWindow.changeProperty('grid-template-columns', val);
    }
    let grid_columns = new customInputOption('columnsInput', 'grid-template-columns', handleColumsChange);
    function handleRowsChange(value) {
        value = parseInt(value);
        if (value < 1) return;
        const val = Array(value).fill('1fr').join(' ');
        window.elementStyleSettingsWindow.changeProperty('grid-template-rows', val);
    }
    let grid_rows = new customInputOption('rowsInput', 'grid-template-rows', handleRowsChange);
    let grid_flow = new selectOption('grid-direction', 'grid-auto-flow');
    let grid_gap_columns = new inputOption('grid-gap-columns', 'grid-column-gap');
    let grid_gap_rows = new inputOption('grid-gap-rows', 'grid-row-gap');

    let margin_left = new inputOption('margin-left', 'margin-left');
    let margin_right = new inputOption('margin-right', 'margin-right');
    let margin_top = new inputOption('margin-top', 'margin-top');
    let margin_bottom = new inputOption('margin-bottom', 'margin-bottom');
    let padding_left = new inputOption('padding-left', 'padding-left');
    let padding_right = new inputOption('padding-right', 'padding-right');
    let padding_top = new inputOption('padding-top', 'padding-top');
    let padding_bottom = new inputOption('padding-bottom', 'padding-bottom');

    let width = new inputOption('width', 'width');
    let min_width = new inputOption('min-width', 'min-width');
    let max_width = new inputOption('max-width', 'max-width');
    let height = new inputOption('height', 'height');
    let min_height = new inputOption('min-height', 'min-height');
    let max_height = new inputOption('max-height', 'max-height');

    let overflow = new selectOption('overflow', 'overflow');

    let aspect_ratio = new selectOption('aspect-ratio', 'aspect-ratio');
    let box_sizing = new selectOption('box-sizing', 'box-sizing');
    let object_fit = new selectOption('object-fit', 'object-fit');

    function handleFitLeftPercentValue(value) {
        value = parseInt(value);
        if (value < 1 || value > 100) return;
        window.elementStyleSettingsWindow.changeProperty('fit-left', `${val}%`);
    }
    let fit_left = new customInputOption('fit-left', 'fit-left', handleFitLeftPercentValue);
    function handleFitTopPercentValue(value) {
        value = parseInt(value);
        if (value < 1 || value > 100) return;
        window.elementStyleSettingsWindow.changeProperty('fit-top', `${val}%`);
    }
    let fit_top = new customInputOption('fit-top', 'fit-top', handleFitTopPercentValue);

    let position = new selectOption('position', 'position');
    let left = new inputOption('left', 'left');
    let right = new inputOption('right', 'right');
    let top = new inputOption('top', 'top');
    let bottom = new inputOption('bottom', 'bottom');
    let z_index = new inputOption('z-index', 'z-index');

    let font_family = new selectOption('font-family', 'font-family');
    let font_weight = new selectOption('font-weight', 'font-weight');
    let font_size = new inputOption('font-size', 'font-size');
    let line_height = new inputOption('line-height', 'line-height');
    let color = new inputOption('color', 'color');
    let text_align = new selectOption('text-align', 'text-align');
    let text_decoration = new selectOption('text-decoration', 'text-decoration');
    let background_clip = new selectOption('background-clip', 'background-clip');
    let border_top_left_radius = new inputOption('border-top-left-radius', 'border-top-left-radius');
    let border_bottom_left_radius = new inputOption('border-bottom-left-radius', 'border-bottom-left-radius');
    let border_top_right_radius = new inputOption('border-top-right-radius', 'border-top-right-radius');
    let border_bottom_right_radius = new inputOption('border-bottom-right-radius', 'border-bottom-right-radius');
    
    let border_top_style = new selectOption('border-top-style', 'border-top-style');
    let border_bottom_style = new selectOption('border-bottom-style', 'border-bottom-style');
    let border_right_style = new selectOption('border-right-style', 'border-right-style');
    let border_left_style = new selectOption('border-left-style', 'border-left-style');
    let border_bottom_width = new inputOption('border-bottom-width', 'border-bottom-width');
    let border_bottom_color = new inputOption('border-bottom-color', 'border-bottom-color');

    let border_top_width = new inputOption('border-top-width', 'border-top-width');
    let border_top_color = new inputOption('border-top-color', 'border-top-color');
    let border_left_width = new inputOption('border-left-width', 'border-left-width');
    let border_left_color = new inputOption('border-left-color', 'border-left-color');
    let border_right_width = new inputOption('border-right-width', 'border-right-width');
    let border_right_color = new inputOption('border-right-color', 'border-right-color');

    function createPropertySetter(propertyName) {
        return function(value) {
            window.elementStyleSettingsWindow.changeProperty(propertyName, value);
        };
    }
    let background_color = new customInputOption('background-color', 'background-color', createPropertySetter('background-color'));

    let gradient = new customInputOption('gradient', 'background', createPropertySetter('background'));
    function setbgimage(value){
        window.elementStyleSettingsWindow.changeProperty('background-image', `url("${value}")`);
    }
    let background_image_url = new customInputOption('background-image-url', 'background-image', setbgimage);
    let background_repeat = new selectOption('background-repeat', 'background-repeat');
    let background_size = new selectOption('background-size', 'background-size');
    let opacity = new inputOption('opacity', 'opacity');
    //todo pozmieniac na customInputOption

    // TODO add the rest
    // ależ kurwa mam głód alkocholowy :cccccc

    window.elementStyleSettingsWindow.options = [layout_options_buttons, flex_direction, column_y, column_x, row_x, row_y, grid_x, grid_y, grid_columns, grid_rows, margin_left,
    margin_right,
    margin_top,
    margin_bottom,
    padding_left,
    padding_right,
    padding_top,
    padding_bottom,
    width,
    min_width,
    max_width,
    height,
    min_height,
    max_height,
    overflow,
    aspect_ratio,
    box_sizing,
    object_fit,
    fit_left,
    fit_top,
    position,
    left,
    right,
    top,
    bottom,
    z_index,
    font_family,
    font_weight,
    font_size,
    line_height,
    color,
    text_align,
    text_decoration,
    background_clip,
    border_top_left_radius,
    border_bottom_left_radius,
    border_top_right_radius,
    border_bottom_right_radius,
    border_top_style,
    border_bottom_style,
    border_right_style,
    border_left_style,
    border_bottom_width,
    border_bottom_color,
    border_top_width,
    border_top_color,
    border_left_width,
    border_left_color,
    border_right_width,
    border_right_color,
    opacity,
    ]; // TODO add the rest

    window.elementStyleSettingsWindow.initTabswithButtons('layout-options-buttons', 'layout-tabs-content', [flex_direction]);
    window.elementStyleSettingsWindow.initTabswithSelect('flex-direction', 'flex-direction-tabs-content', [column_y, column_x, row_x, row_y, grid_x, grid_y, flex_c_gap_columns, flex_c_gap_rows, flex_r_gap_columns, flex_r_gap_rows , grid_columns, grid_rows, grid_flow, grid_gap_columns, grid_gap_rows]);
    window.elementStyleSettingsWindow.initTabswithSelect('bg-type', 'bg-type-tabs-content', [
        background_color,
        gradient,
        background_image_url,
        background_repeat,
        background_size,
    ]);

});

// TODO trzeba bedzie zrobić jsona z wartościami do bazy xdd
// i potem setdefaultvalues na values z tego jsona omgggggg, ale kurwa roboty, potrzebuje piwa...
// TODO możę nie zamykaj jak coś prubuje zaznaczyć xdddddd

// TODO może zmienić te window.sth na export const, to bedzie lepsze xdd
// TODO zgub focus jeśli zamykane są okeinka
// o ja jeba ale jest kurwa roboty w pizdu
// zesram sieeeeee

//TODO wymyślić jak zrobić klasy w elementach takie jak w webflow i aby współgrały ze statycznymi elementami