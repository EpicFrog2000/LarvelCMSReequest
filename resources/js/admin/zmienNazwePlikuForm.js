import { defaultWindow } from './defaultWindow.js';

class zmienNazwePlikuForm extends defaultWindow {
    init() {
        super.init?.();
        this.FormElement = this.WindowElement.querySelector("#adminForm");
        this.FormElement.addEventListener("submit", (e) => {
            e.preventDefault();
            this.changeName();
            this.hideWindowElement();
        });

    }

    showWindowElement() {
        super.showWindowElement?.();
        window.zarzadzaniePlikamiMenu.hideContextMenu();
    }

    changeName() {
        const formData = new FormData(this.FormElement);
        fetch("/changeName", {
            method: "POST",
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => {
                if (!response.ok) throw new Error("Błąd sieci");
                return response.json();
            })
            .then(data => {
                console.log("Zmieniono plik");
                window.zarzadzaniePlikamiWindow.refreshWindow();
            })
            .catch(error => {
                alert.error("Błąd:", error);
            });
    }
}


document.addEventListener('DOMContentLoaded', () => {
    window.zmienNazwePlikuForm = new zmienNazwePlikuForm(document.getElementById('zmienNazwePlikuForm'));
});