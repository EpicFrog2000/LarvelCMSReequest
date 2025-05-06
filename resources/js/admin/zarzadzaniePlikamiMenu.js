import { contextMenu } from './contextMenu.js';

class zarzadzaniePlikamiMenu extends contextMenu {
    init() {
        super.init?.();
        this.changeNameForm = document.getElementById('changeNameForm');



        document.getElementById('kopiujLink').addEventListener('click', () => {
            this.kopiujLink();
        });
        document.getElementById('usunFolder').addEventListener('click', () => {
            const path = this.targetElement.getAttribute('data-path');
            this.usunFolder(path);
        });
        document.getElementById('dodajPliki').addEventListener('click', () => {
            this.dodajPliki();
        });
        document.getElementById('dodajFolder').addEventListener('click', () => {
            this.dodajFolder();
        });
        document.getElementById('zmienNazwe').addEventListener('click', () => {
            this.zmienNazwe();
        });
        document.getElementById('usunPlik').addEventListener('click', () => {
            const path = this.targetElement.getAttribute('data-path');
            this.usunPlik(path);
        });
    }

    handleContextMenu(event) {
        if (event.ctrlKey) {
            return;
        }
        event.preventDefault();
        if (!window.zarzadzaniePlikamiWindow.WindowElement.classList.contains('visible')) {
            return;
        }
        if (window.zmienNazwePlikuForm.WindowElement.classList.contains('visible')) {
            return;
        }
        super.handleContextMenu?.(event);
    }

    getTargetElement(targetElement) {
        if (targetElement.classList.contains('adminFileItem')) {
            this.targetElement = targetElement;
        } else if (targetElement.parentElement.classList.contains('adminFileItem')) {
            this.targetElement = targetElement.parentElement;
        } else if (targetElement.classList.contains('window')) {
            this.targetElement = targetElement;
        }
        else {
            this.targetElement = undefined;
        }
    }

    showcontextMenu() {
        if (this.targetElement) {
            if (this.targetElement.classList.contains('window')) {
                this.showOption('dodajFolder');
                this.showOption('dodajPliki');
                super.showcontextMenu?.();
            } else {
                if (this.targetElement.dataset.prev) {
                    this.hideOptions();
                    this.hideContextMenu();
                    return;
                }
                super.showcontextMenu?.();
                const path = this.targetElement.getAttribute('data-path');
                if (path.endsWith("\\") || path.endsWith("/")) {
                    this.showOption('usunFolder');
                    this.showOption('kopiujLink');
                    this.showOption('zmienNazwe');
                } else {
                    this.showOption('usunPlik');
                    this.showOption('kopiujLink');
                    this.showOption('zmienNazwe');
                }
            }
        }
    }

    kopiujLink() {
        navigator.clipboard.writeText(this.targetElement.getAttribute('data-path'));
        setTimeout(() => {
            this.hideContextMenu();
        }, 50);
    }

    usunFolder(path) {
        fetch("/deleteFileOrFolder", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

            },
            body: JSON.stringify({ path: path })
        })
            .then(response => {
                if (!response.ok) throw new Error("Błąd sieci");
                return response.json();
            })
            .then(data => {
                console.log("Usunięto zasoby:", data);
                window.zarzadzaniePlikamiWindow.refreshWindow();
                this.hideContextMenu();
            })
            .catch(error => {
                console.error("Błąd:", error);
            });
    }


    usunPlik(path) {
        fetch("/deleteFileOrFolder", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

            },
            body: JSON.stringify({ path: path })
        })
            .then(response => {
                if (!response.ok) throw new Error("Błąd sieci");
                return response.json();
            })
            .then(data => {
                console.log("Usunięto zasoby:", data);
                window.zarzadzaniePlikamiWindow.refreshWindow();
                this.hideContextMenu();
            })
            .catch(error => {
                console.error("Błąd:", error);
            });
    }

    dodajPliki() {
        this.contextMenuElement.querySelector('#fileInput').click();
    }

    dodajFolder() {
        const formData = new FormData();
        formData.append('path', window.zarzadzaniePlikamiWindow.currentPath);
        fetch('/createNewFolder', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => response.json())
            .then(data => {
                console.log('Utworzono folder', data);
                window.zarzadzaniePlikamiWindow.refreshWindow();
                this.hideContextMenu();
            })
            .catch(error => {
                console.error('Błąd podczas przesyłania plików', error);
                this.hideContextMenu();
            });
    }

    zmienNazwe() {
        window.zmienNazwePlikuForm.WindowElement.querySelector('#currentName').value = this.targetElement.getAttribute('data-path');
        window.zmienNazwePlikuForm.WindowElement.querySelector('#newName').value = '';
        window.zmienNazwePlikuForm.showWindowElement();
    }

    handleFileSelect(event) {
        const files = event.target.files;
        if (files.length > 0) {
            const formData = new FormData();
            Array.from(files).forEach(file => {
                formData.append('files[]', file);
            });
            formData.append('path', window.zarzadzaniePlikamiWindow.currentPath);
            fetch('/uploadFiles', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Pliki przesłane pomyślnie', data);
                    window.zarzadzaniePlikamiWindow.refreshWindow();
                    this.hideContextMenu();
                })
                .catch(error => {
                    console.error('Błąd podczas przesyłania plików', error);
                    this.hideContextMenu();
                });
        }
    }
}


document.addEventListener('DOMContentLoaded', () => {
    window.zarzadzaniePlikamiMenu = new zarzadzaniePlikamiMenu(document.getElementById('zarzadzaniePlikamiMenu'));
});