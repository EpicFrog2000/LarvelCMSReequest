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
                    childTag === 'WYSWIGELEMENT' ||
                    child.getAttribute('data-type') === 'media'
                ) {
                    values.push(this.getElementsChildren(child, index + 1)); // order starts from 1
                }
            });

            return {
                id: parseInt(element.getAttribute('data-id')),
                order: order,
                values: values
            };

        } else if (tag === 'WYSWIGELEMENT') {
            const values = Array.from(element.getElementsByTagName('wyswigvariable')).map(v => v.innerHTML);
            return {
                id: parseInt(element.getAttribute('data-id')),
                order: order,
                values: values
            };

        } else if (isMedia && 'src' in element) {
            return {
                id: parseInt(element.getAttribute('data-id')),
                order: order,
                values: [element.src]
            };
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
        let modifiedValues = this.getElementsStructure();

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


        // console.log(JSON.stringify(modifiedValues_v2, null, 2));
        // console.log(JSON.stringify(startValues, null, 2));

        // console.log(modifiedValues_v2);
        // console.log(startValues);


        // let json1 = JSON.stringify(modifiedValues_v2, null, 2);
        // let json2 = JSON.stringify(startValues, null, 2);

        function compareObjects(objA, objB) {
            let differences = {};
            for (const key in objA) {
                if (objA[key] !== objB[key]) {
                    differences[key] = { before: objA[key], after: objB[key] };
                }
            }
            return Object.keys(differences).length > 0 ? differences : null;
        }

        function compareFields(a, b) {
            const keysToCompare = ['id', 'value', 'order'];
            let differences = {};

            for (const key of keysToCompare) {
                if (a[key] !== b[key]) {
                    differences[key] = { before: a[key], after: b[key] };
                }
            }

            return Object.keys(differences).length > 0 ? differences : null;
        }

        function deepEqual(a, b) {
            return JSON.stringify(a) === JSON.stringify(b);
        }

        function compareFields(a, b) {
            let differences = {};

            if (a.id !== b.id) {
                differences.id = { before: a.id, after: b.id };
            }

            if (a.order !== b.order) {
                differences.order = { before: a.order, after: b.order };
            }
            
            if (a.values && typeof(a.values) == Array) {
                
            }

            return Object.keys(differences).length > 0 ? differences : null;
        }

        function compare(obj1, obj2) {
            let total = { deleted: [], added: [], modified: [] };

            const map1 = new Map(obj1.map(item => [item.id, item]));
            const map2 = new Map(obj2.map(item => [item.id, item]));

            // Sprawdź usunięte i zmodyfikowane
            for (const [id, item1] of map1.entries()) {
                const item2 = map2.get(id);
                if (!item2) {
                    total.deleted.push(item1);
                } else {
                    const diff = compareFields(item1, item2);
                    if (diff) {
                        console.log(diff);
                    }
                }
            }

            // Sprawdź dodane
            for (const [id, item2] of map2.entries()) {
                if (!map1.has(id)) {
                    total.added.push(item2);
                }
            }

            return total;
        }




        console.log(compare(startValues, modifiedValues_v2));

        // console.log(this.compareStructures(startValues, modifiedValues_v2));

    }
}