export class Action {
    constructor() {
        if (this.constructor === Action) {
            throw new Error("Abstract classes can't be instantiated.");
        }
    }
}