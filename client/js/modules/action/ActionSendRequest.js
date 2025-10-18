import {Action} from "./Action.js";
import {Elemental} from "../Elemental.js";

export class ActionSendRequest extends Action {
    constructor() {
        super();
        this.element = new Elemental().getByKeys(['formSendRequest']);
        Object.freeze(this)
    }

    init() {
        const form = this.element.formSendRequest;

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            this.sendForm(form);
            this.showToast()
            this.clearInputs()
        });
    };

    showToast(message) {
        const toast = document.createElement('div');
        toast.innerText = message;

        Object.assign(toast.style, {
            position: 'fixed',
            bottom: '20px',
            right: '20px',
            backgroundColor: '#1bbf83',
            color: '#fff',
            padding: '12px 24px',
            borderRadius: '5px',
            fontSize: '16px',
            zIndex: 10000,
            opacity: '1',
            transition: 'opacity 0.5s ease',
            pointerEvents: 'auto',
        });

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => {
                toast.remove();
            }, 500);
        }, 5000);
    }

    clearInputs() {
        const idsToClear = ['field-site', 'additional-message'];
        idsToClear.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                const tagName = element.tagName.toLowerCase();
                if (tagName === 'input') {
                    element.value = '';
                } else if (tagName === 'textarea') {
                    element.value = '';
                }
            }
        });
    }

    sendForm(form) {
        fetch('server/form/add_new_provider.php', {
            method: 'POST',
            body: new FormData(form)
        })
            .then(response => response.json())
            .then(data => alert(data.status))
            .catch(error => alert('Ошибка: ' + error));
    }
}