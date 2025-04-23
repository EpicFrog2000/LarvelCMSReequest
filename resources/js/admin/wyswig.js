
function SaveWyswigChanges(new_values, original_values){
    var differences = compareArrays(new_values, original_values);
    if (differences.added || !differences.removed || !differences.modified) {
        fetch('/seeChanges', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                Changes: differences
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Błąd: ${response.statusText} (status: ${response.status})`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Odpowiedź serw era:', data);
        })
        .catch(error => {
            console.error('Wystąpił błąd:', error);
            alert('Wystąpił problem podczas próby wysłania danych. Proszę spróbować ponownie.');
        });
    }
}
window.SaveWyswigChanges = SaveWyswigChanges;

function compareArrays(newArray, oldArray) {
    const added = [];
    const removed = [];
    const modified = [];

    newArray.forEach(newItem => {
        const oldItem = oldArray.find(item => item.id === newItem.id);

        if (!oldItem) {
            added.push(newItem);
            console.log(newItem);
        } else if (JSON.stringify(newItem.jsonvariables) !== JSON.stringify(oldItem.jsonvariables)) {
            modified.push({
                id: newItem.id,
                jsonvariables: newItem.jsonvariables
            });
        }
    });

    oldArray.forEach(oldItem => {
        const newItem = newArray.find(item => item.id === oldItem.id);
        if (!newItem) {
            removed.push(oldItem);
        }
    });

    return {
        added,
        removed,
        modified
    };
}

function GetValuesFromTemplate(Elements, View_name) {
    var parsed_values = [];
    for (const key in Elements) {
        if (Object.hasOwn(Elements, key)) {
            const arr = Elements[key];
            arr.forEach((item, index) => {
                if (typeof item.value === 'string') {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = item.value;

                    const wyswigElements = tempDiv.getElementsByTagName('wyswigTemplateValue');
                    let jsonvariables = [];

                    for (const el of wyswigElements) {
                        jsonvariables.push(el.textContent);
                    }
                    let element = {
                        jsonvariables: jsonvariables,
                        id: item.id,
                        dev_name: key,
                        view_name: View_name,
                    };

                    parsed_values.push(element);
                }
            });
        }
    }
    return parsed_values;
}
window.GetValuesFromTemplate = GetValuesFromTemplate;


function addWyswigElement(wyswigContainerElement){
    fetch(`/wyswig-element/${wyswigContainerElement.id}`)
    .then(response => response.text())
    .then(html => {
        wyswigContainerElement.innerHTML += html;
    })
    .catch(error => {
        console.error('Error loading wyswig element:', error);
    });
}
window.addWyswigElement = addWyswigElement;

function removeWyswigElement(wyswigContainerElement, index) {
    if (index >= 0 && index < wyswigContainerElement.children.length) {
        wyswigContainerElement.removeChild(wyswigContainerElement.children[index]);
    }
}
window.removeWyswigElement = removeWyswigElement;