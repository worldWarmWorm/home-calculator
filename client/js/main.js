import {ActionSwitchTab} from "./modules/ActionSwitchTab.js";
import {ActionCalculate} from "./modules/ActionCalculate.js";

document.addEventListener("DOMContentLoaded", () => {
    new ActionSwitchTab().init()
    new ActionCalculate().init();
});