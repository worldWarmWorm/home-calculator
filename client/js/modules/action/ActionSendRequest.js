import {Action} from "./Action.js";
import {Elemental} from "../Elemental.js";
import {Toast} from "../content/Toast.js";
import {Input} from "../content/Input.js";

export class ActionSendRequest extends Action {
    constructor() {
        super();
        this.element = new Elemental().getByKeys(['formSendRequest', 'fieldSite', 'additionalMessage']);
        Object.freeze(this)
    }

    init() {
        const form = this.element.formSendRequest;
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            this.addNewProvider(form);
        });
    };

    addNewProvider(form) {
        fetch(
            'server/form/add_new_provider.php',
            {
                method: 'POST',
                body: new FormData(form)
            }
        )
            .then(response => response.json())
            .then(data => {
                if (data.success === false) {
                    alert(data.message)
                } else {
                    new Toast('Заявка отправлена!').show()
                    new Input([this.element.fieldSite, this.element.additionalMessage]).clear()
                }
                return data
            })
            .catch(error => console.error('Ошибка: ' + error));
    }
}