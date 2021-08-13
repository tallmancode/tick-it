export default {
    normalizeFields ($tableFields) {
        if (!Array.isArray($tableFields)) {
            console.warn('Table fields should be a array');
            return;
        }

        let returnArray = [];

        let obj;

        $tableFields.forEach((field, i) => {
            if (typeof (field) === 'string') {
                obj = {
                    name: field,
                    title: this.setTitle(field),
                    titleClass: '',
                    dataClass: '',
                    callback: null,
                    visible: true,
                };
            } else {
                obj = {
                    name: field.name,
                    title: (field.title === undefined) ? this.setTitle(field.name) : field.title,
                    titleClass: (field.titleClass === undefined) ? '' : field.titleClass,
                    dataClass: (field.dataClass === undefined) ? '' : field.dataClass,
                    callback: (field.callback === undefined) ? '' : field.callback,
                    visible: (field.visible === undefined) ? true : field.visible,
                };
            }
            returnArray.push(obj);
        });
        return returnArray;
    },

    getSpecialFieldName (fieldName) {
        return fieldName.split(':')[1];
    },

    isSpecialField (fieldName) {
        return fieldName.slice(0, 2) === '__';
    },

    setTitle (str) {
        if (this.isSpecialField(str)) {
            return '';
        }

        return this.titleCase(str);
    },

    titleCase (str) {
        return str.replace(/\w+/g, function (txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        });
    },

    objValue(obj, is) {
        let parts = is.split('.');
        let newObj = obj[parts[0]];
        if (parts[1]) {
            parts.splice(0, 1);
            let newString = parts.join('.');
            return this.objValue(newObj, newString);
        }
        return newObj;
    },
    warn (msg) {
        if (!this.silent) {
            console.warn(msg);
        }
    },

};
