export class Toast {
    constructor(message) {
        this.message = message;
        Object.freeze(this)
    }

    show() {
        const toast = document.createElement('div');
        toast.innerText = this.message;

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
}