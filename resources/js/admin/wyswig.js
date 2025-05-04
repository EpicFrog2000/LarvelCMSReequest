function getWyswigModules() {
    return fetch('/getWyswigModules')
        .then(response => response.json())
        .catch(error => {
            console.error('Error fetching templates:', error);
            return [];
        });
}
window.getWyswigModules = getWyswigModules;

function getWyswigTemplate(dev_name) {
    return fetch(`/getWyswigTemplate/${dev_name}`)
        .then(response => response.text())
        .then(data => {
            return data;
        })
        .catch(error => {
            console.error('Error fetching templates:', error);
            return '';
        });
}
window.getWyswigModules = getWyswigModules;