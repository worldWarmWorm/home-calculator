import {ActionSwitchTab} from "./modules/action/ActionSwitchTab.js";
import {ActionCalculate} from "./modules/action/ActionCalculate.js";

export class App {
    constructor() {
        this.actions = [
            new ActionSwitchTab(),
            new ActionCalculate(),
        ]
        Object.freeze(this)
    }

     start() {
        document.addEventListener("DOMContentLoaded", () => {
            this.actions.map((action) => action.init())
        });
    }
}