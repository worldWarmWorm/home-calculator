export class Elemental {
    getRegisteredElements() {
        return {
            item: document.querySelectorAll('.item'),
            tabSwitcher: document.querySelector('.tab-switcher'),
            tabContent: document.querySelectorAll('.tab-content'),
            provider: document.querySelectorAll('.provider'),
            btnCalc: document.getElementById('btn-calc'),
            result: document.getElementById('result')
        }
    }

    getByKeys(keys) {
        return Object.fromEntries(
            Object.entries(this.getRegisteredElements()).filter(([key]) => keys.includes(key))
        );
    }
}