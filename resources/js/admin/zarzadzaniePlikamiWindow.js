import { defaultWindow } from './defaultWindow.js';

class zarzadzaniePlikamiWindow extends defaultWindow {
    init() {
        super.init?.();
        this.pathElement = document.getElementById('zarzadzaniePlikamiPath');
        this.ItemsContainer = document.getElementById('adminFilesContent');
        this.dropMessageElement = document.getElementById('dropMessage');
        this.defaultPath = 'media/';
        this.currentPath = 'media/';
    }

    handleDroppedContent(content) {
        alert(`Odebrano content: `);
    }

    handleDocumentClick(event) {
        if (!window.zarzadzaniePlikamiMenu.contextMenuElement.classList.contains('visible')) {
            if (!window.zmienNazwePlikuForm.WindowElement.contains(event.target)) {
                super.handleDocumentClick?.(event);
            }
        }
    }

    showWindowElement() {
        super.showWindowElement?.();
        window.adminMenu.hideContextMenu();
        this.setItems(this.defaultPath);
    }

    hideWindowElement(){
        super.hideWindowElement?.();
        this.clearItems();
    }

    getFilesAndFolders(path) {
        const formattedPath = path.startsWith('/') ? path : `/${path}`;
        return fetch(`/getFilesAndFolders${formattedPath}`)
            .then(response => response.json())
            .catch(error => {
                console.error('Error fetching files:', error);
            });
    }

    clearItems() {
        this.ItemsContainer.innerHTML = '';
    }

    setItems(path) {
        this.getFilesAndFolders(path).then(items => {
            let folders = items.folders || [];
            let files = items.files || [];
            this.clearItems();
            this.setPathText(path);
            this.currentPath = path;
            if (path != this.defaultPath) {
                this.addBackButton();
            }
            folders.forEach(folder => {
                this.addFolderElement(folder);
            });
            files.forEach(file => {
                this.addFileElement(file);
            });
        }).catch(error => {
            console.error('Error setting items:', error);
        });
    }

    addFileElement(file) {
        const fileElement = document.createElement('div');
        fileElement.classList.add('adminFileItem');
        fileElement.dataset.path = file.path;

        const fileImage = document.createElement('img');
        fileImage.src = 'media/NoImage.jpg';
        fileImage.style.width = '100%';
        fileImage.style.height = 'auto';

        const fileName = document.createElement('p');
        fileName.innerHTML = file.filename;

        fileElement.appendChild(fileImage);
        fileElement.appendChild(fileName);

        fileElement.addEventListener('click', () => {
            //this.setItems(file.path);
            // TODO
        });

        this.ItemsContainer.appendChild(fileElement);
    }

    addFolderElement(folder) {
        const folderElement = document.createElement('div');
        folderElement.classList.add('adminFileItem');
        folderElement.dataset.path = folder.path;

        const folderImage = document.createElement('img');
        folderImage.src = 'media/FolderImage.png';
        folderImage.style.width = '100%';
        folderImage.style.height = 'auto';

        const folderName = document.createElement('p');
        folderName.innerHTML = folder.foldername;

        folderElement.appendChild(folderImage);
        folderElement.appendChild(folderName);
        folderElement.style.cursor = 'pointer';
        folderElement.addEventListener('click', () => {
            const normalizedPath = folder.path.replace(/\\/g, '/');
            const relativePath = normalizedPath.match(/media\/.*/)?.[0] ?? '';
            if (!relativePath.endsWith('/')) {
                relativePath += '/';
            }
            this.setItems(relativePath);
        });

        this.ItemsContainer.appendChild(folderElement);
    }

    setPathText(text) {
        this.pathElement.innerHTML = text;
    }

    addBackButton() {
        const folderElement = document.createElement('div');
        folderElement.classList.add('adminFileItem');
        const pathParts = this.currentPath.split('/').filter(part => part);
        pathParts.pop();
        let newPath = pathParts.length > 0 ? pathParts.join('/') + '/' : this.defaultPath;
        folderElement.dataset.prev = true;
        folderElement.dataset.path = newPath;
        

        const folderImage = document.createElement('img');
        folderImage.src = 'media/FolderImage.png';
        folderImage.style.width = '100%';
        folderImage.style.height = 'auto';

        const folderName = document.createElement('p');
        folderName.innerHTML = '...';

        folderElement.appendChild(folderImage);
        folderElement.appendChild(folderName);
        folderElement.style.cursor = 'pointer';
        folderElement.addEventListener('click', () => {
            this.setItems(newPath);
        });

        folderElement.addEventListener('contextmenu', (event) => {
            window.zarzadzaniePlikamiMenu.handleContextMenu(event);
        });

        this.ItemsContainer.appendChild(folderElement);
    }

    refreshWindow(){
        this.clearItems();
        this.setItems(this.currentPath);
    }
}



document.addEventListener('DOMContentLoaded', () => {
    window.zarzadzaniePlikamiWindow = new zarzadzaniePlikamiWindow(document.getElementById('zarzadzaniePlikamiWindow'));
});