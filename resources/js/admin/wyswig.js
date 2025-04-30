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

function getButtonyUstawienElementu(){
    let newButtons = [];
    switch(window.CurrentChosenElement.tagName){
        case 'WYSWIGVARIABLE':
            {
                const button = document.createElement('button');
                button.onclick = change_text;
                button.style = 'padding: 10px 10px;';
                button.textContent = 'Change text';
                newButtons.push(button);
            }
            {
                const button = document.createElement('button');
                button.onclick = edit_style;
                button.style = 'padding: 10px 10px;';
                button.textContent = 'edit style';
                newButtons.push(button);
            }
            {
                const button = document.createElement('button');
                button.onclick = remove_element;
                button.style = 'padding: 10px 10px;';
                button.textContent = 'remove element';
                newButtons.push(button);
            }
            {
                const button = document.createElement('button');
                button.onclick = add_element;
                button.style = 'padding: 10px 10px;';
                button.textContent = 'add element';
                newButtons.push(button);
            }
            {
                const button = document.createElement('button');
                button.onclick = add_container;
                button.style = 'padding: 10px 10px;';
                button.textContent = 'add container';
                newButtons.push(button);
            }
            return newButtons;
            case 'WYSWIGELEMENT':
                {
                    const button = document.createElement('button');
                    button.onclick = edit_style;
                    button.style = 'padding: 10px 10px;';
                    button.textContent = 'edit style';
                    newButtons.push(button);
                }
                {
                    const button = document.createElement('button');
                    button.onclick = remove_container;
                    button.style = 'padding: 10px 10px;';
                    button.textContent = 'remove container';
                    newButtons.push(button);
                }
                {
                    const button = document.createElement('button');
                    button.onclick = add_element;
                    button.style = 'padding: 10px 10px;';
                    button.textContent = 'add element';
                    newButtons.push(button);
                }
                {
                    const button = document.createElement('button');
                    button.onclick = remove_element;
                    button.style = 'padding: 10px 10px;';
                    button.textContent = 'remove element';
                    newButtons.push(button);
                }
                return newButtons;
        case 'WYSWIGCONTAINER':
            {
                const button = document.createElement('button');
                button.onclick = edit_style;
                button.style = 'padding: 10px 10px;';
                button.textContent = 'edit style';
                newButtons.push(button);
            }
            {
                const button = document.createElement('button');
                button.onclick = add_container;
                button.style = 'padding: 10px 10px;';
                button.textContent = 'add container';
                newButtons.push(button);
            }
            {
                const button = document.createElement('button');
                button.onclick = remove_container;
                button.style = 'padding: 10px 10px;';
                button.textContent = 'remove container';
                newButtons.push(button);
            }
            {
                const button = document.createElement('button');
                button.onclick = add_element;
                button.style = 'padding: 10px 10px;';
                button.textContent = 'add element';
                newButtons.push(button);
            }
            return newButtons;
        //MOZE BYĆ WIECEJ
    
        default:
            return [];
    }
}
window.getButtonyUstawienElementu = getButtonyUstawienElementu;

//TODO
// O KURWA NO BĘDZIE CO ROBIĆ XDDDDDDDDDDDDDDDDDD


function change_text(){

}

async function add_element(evt) {
    const targetTab = document.getElementById('ListaElementów');
    const isActive = targetTab.style.display === "block";

    if (evt.currentTarget) {
        if (isActive) {
            evt.currentTarget.classList.remove("active");
            targetTab.style.display = "none";
            return;
        }
        targetTab.style.display = "block";
        evt.currentTarget.classList.add("active");
    } else {
        console.error("Event target is null.");
    }
    targetTab.innerHTML = '';


    const allModules = await getWyswigModules();
    const modules = allModules.filter(name => !name.includes('Container'));
    
    modules.forEach(module_name => {
        const button = document.createElement('button');
        button.style.padding = '10px 10px';
        button.textContent = module_name;
        button.onclick = async () => {
            const Template = await getWyswigTemplate(module_name);
            if(window.CurrentChosenElement.tagName == 'WYSWIGELEMENT'){
                window.CurrentChosenElement.parentElement.innerHTML += Template;
            }else{
                window.CurrentChosenElement.innerHTML += Template;
            }
            
        }

        targetTab.appendChild(button);
    });
}

function remove_element(evt){
    if(window.CurrentChosenElement.tagName == 'WYSWIGVARIABLE'){
        let tmpelem = window.CurrentChosenElement.parentElement;
        while(true){
            if(tmpelem.tagName == 'WYSWIGELEMENT'  || tmpelem.tagName == 'WYSWIGCONTAINER'){
                break;
            }
            tmpelem = tmpelem.parentElement;
        }
        tmpelem.remove();
    }else{
        window.CurrentChosenElement.remove();
    }
    
}

function add_container(){

}

function remove_container(){
    if(window.CurrentChosenElement.tagName != 'WYSWIGCONTAINER'){
        let tmpelem = window.CurrentChosenElement.parentElement;
        while(true){
            if(tmpelem.tagName == 'WYSWIGELEMENT'  || tmpelem.tagName == 'WYSWIGCONTAINER'){
                break;
            }
            tmpelem = tmpelem.parentElement;
        }
        tmpelem.remove();
    }else{
    window.CurrentChosenElement.innerHTML.remove();
    }

}

function edit_style(){
    
}

function zapiszWyswig(){

}

function modifyDataStructure(id, action){
    // ModifiedValues
}

window.zapiszWyswig = zapiszWyswig