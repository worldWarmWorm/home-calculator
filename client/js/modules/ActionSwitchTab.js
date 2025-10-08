import {Action} from "./Action.js";

class ActionSwitchTab extends Action {
    static HIDE = 'hide'
    static ITEM = 'item'
    static ACTIVE = 'active'

    hideContent(key) {
        for (let i = key; i < this.element.tabContent.length; i++) {
            this.element.tabContent[i].classList.add(ActionSwitchTab.HIDE);
        }
    }

    showContent(key) {
        if (this.element.tabContent[key].classList.contains(ActionSwitchTab.HIDE)) {
            this.element.tabContent[key].classList.remove(ActionSwitchTab.HIDE);
        }
    }

    init() {
        this.element.tabSwitcher.addEventListener('click', (event) => {
            let target = event.target;
            if (target && target.classList.contains(ActionSwitchTab.ITEM)) {
                for (let i = 0; i < this.element.item.length; i++) {
                    this.element.item[i].classList.remove(ActionSwitchTab.ACTIVE)
                    if (target === this.element.item[i]) {
                        this.hideContent(0, this.element.tabContent)
                        this.showContent(i, this.element.tabContent);
                        target.classList.add(ActionSwitchTab.ACTIVE);
                    }
                }
            }
        });
    }
}

export {ActionSwitchTab};