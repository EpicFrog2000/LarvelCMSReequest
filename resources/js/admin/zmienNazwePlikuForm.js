import { defaultWindow } from './defaultWindow.js';

class zmienNazwePlikuForm extends defaultWindow {
    init() {   
        super.init?.();

        this.WindowElement.querySelector('#changeNameFormSubmitButton').addEventListener('click', async (e) => {
            e.preventDefault();
            e.stopPropagation();
            const newName = this.WindowElement.querySelector('#newName').value;
            const path = this.WindowElement.querySelector('#currentName').value;
            fetch('/changeName', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    newName: newName,
                    path: path
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Success:", data);
            })
            .catch(error => {
                console.error("Error:", error);
            });
            return false;
        });
    }

    showWindowElement() {
        super.showWindowElement?.();
        window.zarzadzaniePlikamiMenu.hideContextMenu();
    }
}


document.addEventListener('DOMContentLoaded', () => {
    window.zmienNazwePlikuForm = new zmienNazwePlikuForm(document.getElementById('zmienNazwePlikuForm'));
});