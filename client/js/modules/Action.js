import {Elemental} from "./Elemental.js";

class Action {
    constructor() {
        if (this.constructor === Action) {
            throw new Error("Abstract classes can't be instantiated.");
        }
        this.element = new Elemental().getByKeys(["item", "tabSwitcher", "tabContent"]);
        Object.freeze(this)
    }
}

export {Action};