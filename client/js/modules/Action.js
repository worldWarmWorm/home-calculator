import {Elemental} from "./Elemental.js";

class Action {
    constructor() {
        if (this.constructor === Action) {
            throw new Error("Abstract classes can't be instantiated.");
        }
        this.el = new Elemental();
        Object.freeze(this)
    }
}

export {Action};