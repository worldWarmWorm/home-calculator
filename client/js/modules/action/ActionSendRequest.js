import {Action} from "./Action.js";
import {Elemental} from "../Elemental.js";

export class ActionSendRequest extends Action {

    constructor() {
        super();
        this.element = new Elemental().getByKeys(['btnSendRequest']);
        Object.freeze(this)
    }

    init() {
        this.element.btnSendRequest.addEventListener('click', (event) => {
            event.preventDefault();
            this.clearInputs();
            this.showToast('Запрос отправлен')
        });
    };

    showToast(message) {
        const toast = document.createElement('div');
        toast.innerText = message;

        Object.assign(toast.style, {
            position: 'fixed',
            bottom: '20px',
            right: '20px',
            backgroundColor: 'rgba(0,0,0,0.8)',
            color: '#fff',
            padding: '12px 24px',
            borderRadius: '5px',
            fontSize: '14px',
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
                this.clearInputs();
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
}