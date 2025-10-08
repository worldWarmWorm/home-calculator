class Elemental {
    getRegisteredElements() {
        return {
            item: document.querySelectorAll(".item"),
            tabSwitcher: document.querySelector(".tab-switcher"),
            tabContent: document.querySelectorAll(".tab-content"),
            provider: document.querySelectorAll(".provider")
        }
    }

    getByKeys(keys) {
        return Object.fromEntries(
            Object.entries(this.getRegisteredElements()).filter(([key]) => keys.includes(key))
        );
    }
}

export {Elemental};