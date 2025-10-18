export class Input {
    constructor(fields) {
        this.fields = fields;
        Object.freeze(this)
    }

    clear() {
        this.fields.forEach(field => {
            if (field) {
                const tagName = field.tagName.toLowerCase();
                if (tagName === 'input' || tagName === 'textarea') {
                    field.value = '';
                }
            }
        });
    }
}