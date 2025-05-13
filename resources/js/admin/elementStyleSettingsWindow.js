import { defaultWindow } from './defaultWindow.js';


class elementStyleSettingsWindow extends defaultWindow {
    init() {
        super.init?.();
    }


    
}

document.addEventListener('DOMContentLoaded', () => {
    window.elementStyleSettingsWindow = new elementStyleSettingsWindow(document.getElementById('elementStyleSettingsWindow'));
});