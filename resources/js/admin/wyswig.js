export class wyswigEditor {
    constructor() {
        throw new Error("wyswigEditor to klasa statyczna - nie można jej instancjonować");
    }

    static editStyle() {

    }

    static remove() {

    }

    static editText() {

    }

    static addContainer() {

    }

    static addElement() {

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


    static getElementsStructure() {
        let values = [];
        const wyswigpagedatas = document.getElementsByTagName('wyswigpagedata');
        Array.from(wyswigpagedatas).forEach(wyswigpagedata => {
            Array.from(wyswigpagedata.children).forEach((element, index) => {
                values.push({ structure: this.getElementsChildren(element, index + 1) });
            });
        });
        return values;
    }

    static getElementsChildren(element, order = 1) {
        const tag = element.tagName.toUpperCase();
        const isMedia = element.getAttribute('data-type') === 'media';
        
        if (tag === 'WYSWIGCONTAINER') {
            const children = Array.from(element.children);
            const values = [];

            children.forEach((child, index) => {
                const childTag = child.tagName.toUpperCase();
                if (
                    childTag === 'WYSWIGCONTAINER' ||
                    childTag === 'WYSWIGELEMENT'
                ) {
                    values.push(this.getElementsChildren(child, index + 1));
                }
            });

            return {
                id: parseInt(element.getAttribute('data-id')),
                order: order,
                values: values
            };

        } else if (tag === 'WYSWIGELEMENT') {
            let valuesvalues = {};
            
            const elements = Array.from(element.getElementsByTagName('wyswigvariable'));
            elements.forEach(el => {
                let id = el.getAttribute('data-id');
                if (id !== null) {
                    valuesvalues[id] = {'value': el.innerHTML};
                }
            });

            const media_elements = Array.from(element.getElementsByTagName('img'));
            media_elements.forEach(el => {
                let id = el.getAttribute('data-id');
                if (id !== null) {
                    valuesvalues[id] = {'value': el.src};
                }
            });


            let value = {};
            value.id = parseInt(element.getAttribute('data-id'));
            value.order = order;
            value.values = valuesvalues;

            return value;



        } else if (isMedia && 'src' in element) {
            let objects = {};
            objects[parseInt(element.getAttribute('data-id'))] = element.src;
            return objects;
        }

        return null;
    }


    static compareStructures(original = [], modified = []) {
        const added = [];
        const removed = [];
        const changed = [];

        const modifiedMap = new Map(modified.map(el => [el.id, el]));

        for (const originalElement of original) {
            const match = modifiedMap.get(originalElement.id);
            if (!match) {
                removed.push(originalElement);
            } else {
                // Compare filled_template
                if (originalElement.filled_template !== match.filled_template) {
                    changed.push({ before: originalElement, after: match });
                }

                // Recursive compare of nested values
                const diff = this.compareStructures(
                    originalElement.values || [],
                    match.values || []
                );

                added.push(...diff.added);
                removed.push(...diff.removed);
                changed.push(...diff.changed);
            }
        }

        // Detect added elements
        const originalIds = new Set(original.map(el => el.id));
        for (const modifiedElement of modified) {
            if (!originalIds.has(modifiedElement.id)) {
                added.push(modifiedElement);
            }
        }

        return { added, removed, changed };
    }

    static zapiszWyswig() {

        var variable_changes = [];
        var elements_changes = [];
        let BIGelement_changes = { deleted: [], added: [], modified: [] };

        let modifiedValues = this.getElementsStructure();

        // Parsowanie do wygodniejszej postaci
        let modifiedValues_v2 = [];
        Array.from(modifiedValues).forEach(modifiedValue => {
            Object.entries(modifiedValue).forEach(([key, value]) => {
                modifiedValues_v2.push(value);
            });
        });

        let startValues = []
        Array.from(window.StartValues).forEach(modifiedValue => {
            Object.entries(modifiedValue).forEach(([key, value]) => {
                startValues.push(value);
            });
        });




        function compareObject(a, b) {
            let differences = {};

            if (a.order !== b.order) {
                differences.order = { before: a.order, after: b.order };
            }

            if(Object.keys(differences).length > 0){
                differences.id = a.id;
            }else{
                return null;
            }

            return differences;
        }

        function compareObj(a, b){
            const aValues = Array.isArray(a.values) ? a.values : [];
            const bValues = Array.isArray(b.values) ? b.values : [];

            if(aValues.length > 0){
                const map1 = new Map(aValues.map(item => [item.id, item]));
                const map2 = new Map(bValues.map(item => [item.id, item]));

                // Sprawdź usunięte i zmodyfikowane
                for (const [id, item1] of map1.entries()) {
                    const item2 = map2.get(id);
                    if (!item2) {
                        BIGelement_changes.deleted.push(item1);
                    } else {
                        const diff = compareObject(item1, item2);
                        if (diff) {
                            elements_changes.push(diff);
                        }
                        let changes = compareObj(item1, item2);
                        if(changes){
                            variable_changes.push(changes);
                        }
                    }
                }
                for (const [id, item2] of map2.entries()) {
                    if (!map1.has(id)) {
                        BIGelement_changes.added.push(item2);
                    }
                }
            }else{
                let changes = {};
                function ensureTrailingSlash(path) {
                    return path.startsWith('/') ? path.slice(1) : path;
                }

                for (const id in a.values) {
                    if (b.values.hasOwnProperty(id)) {
                        let aVal = a.values[id].value;
                        let bVal = b.values[id].value;

                        try {
                            aVal = new URL(aVal).pathname;
                            aVal = ensureTrailingSlash(aVal);
                        } catch (e) {}
                        try {
                            bVal = new URL(bVal).pathname;
                            bVal = ensureTrailingSlash(bVal);
                        } catch (e) {}

                        if (aVal !== bVal) {
                            changes[id] = {
                                from: aVal,
                                to: bVal
                            };
                        }
                    }
                }

                if (Object.keys(changes).length > 0) {
                    return changes;
                }else{
                    return null;
                }
            }
        }

        function compare(obj1, obj2) {
            const map1 = new Map(obj1.map(item => [item.id, item]));
            const map2 = new Map(obj2.map(item => [item.id, item]));

            // Sprawdź usunięte i zmodyfikowane
            for (const [id, item1] of map1.entries()) {
                const item2 = map2.get(id);
                if (!item2) {
                    BIGelement_changes.deleted.push(item1);
                } else {
                    const diff = compareObject(item1, item2);
                    if (diff) {
                        elements_changes.push(diff);
                    }
                    let changes = compareObj(item1, item2);
                    if(changes){
                        variable_changes.push(changes);
                    }
                }
            }

            // Sprawdź dodane
            for (const [id, item2] of map2.entries()) {
                if (!map1.has(id)) {
                    BIGelement_changes.added.push(item2);
                }
            }

            return BIGelement_changes;
        }

        BIGelement_changes = compare(startValues, modifiedValues_v2);
        console.log("BIGelement_changes: ", BIGelement_changes);
        console.log("this.elements_changes: ", elements_changes);
        console.log("this.variable_changes: ", variable_changes);
        
        this.saveWyswig(BIGelement_changes, elements_changes, variable_changes);

    }

    static saveWyswig(BIGelement_changes, elements_changes, variable_changes) {
        return fetch('/saveWyswig', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ BIGelement_changes, elements_changes, variable_changes })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            return true;
        })
        .catch(error => {
            console.error('Error fetching templates:', error);
            return false;
        });
    }
}


// japierole Andrzej robił to 5 lat?
// ale się wjebałem w bagno...