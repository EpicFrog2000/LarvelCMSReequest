export class wyswigEditor{
    constructor() {
        throw new Error("wyswigEditor to klasa statyczna - nie można jej instancjonować");
    }

    static editStyle() {
        
    }
    
    static remove() {
    
    }
    
    static editText() {
    
    }
    
    static addContainer(){
    
    }
    
    static addElement(){
    
    }

    static getWyswigModules() {
        return fetch('/getWyswigModules')
            .then(response => response.json())
            .catch(error => {
                console.error('Error fetching templates:', error);
                return [];
            });
    }
    
    static getWyswigTemplate(dev_name) {
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


    static getElementsStructure(){

    }

    static zapiszWyswig(){
        // old: window.StartValues
        // new: window.StartValues
        //TODO KURWA NIE DZIAŁA XDDD
        function getDifferences(oldObj, newObj, path = '') {
            const changes = [];
        
            const allKeys = new Set([...Object.keys(oldObj || {}), ...Object.keys(newObj || {})]);
        
            allKeys.forEach(key => {
                const fullPath = path ? `${path}.${key}` : key;
                const oldVal = oldObj?.[key];
                const newVal = newObj?.[key];
        
                if (oldVal !== undefined && newVal === undefined) {
                    changes.push({
                        path: fullPath,
                        before: oldVal,
                        after: undefined
                    });
                    return;
                }
        
                if (oldVal === undefined && newVal !== undefined) {
                    changes.push({
                        path: fullPath,
                        before: undefined,
                        after: newVal
                    });
                    return;
                }
        
                if (typeof oldVal === 'object' && oldVal !== null &&
                    typeof newVal === 'object' && newVal !== null) {
                    changes.push(...getDifferences(oldVal, newVal, fullPath));
                } else if (JSON.stringify(oldVal) !== JSON.stringify(newVal)) {
                    changes.push({
                        path: fullPath,
                        before: oldVal,
                        after: newVal
                    });
                }
            });
        
            return changes;
        }
        window.StartValues.forEach((obj, i) => {
            const key = Object.keys(obj)[0];
            const oldNode = obj[key];
            const newNode = window.ModifiedValues[i]?.[key];
        
            const diffs = getDifferences(oldNode, newNode);
        
            if (diffs.length > 0) {
                console.log(`Changes for node ${key}:`, diffs);
            }
        });


        
    }
}