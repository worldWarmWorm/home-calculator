import {Action} from "./Action.js";

class ActionSwitchTab extends Action {
    static HIDE = 'hide'
    static ITEM = 'item'
    static ACTIVE = 'active'

    hideContent(key) {
        for (let i = key; i < this.el.tabContent.length; i++) {
            this.el.tabContent[i].classList.add(ActionSwitchTab.HIDE);
        }
    }

    showContent(key) {
        if (this.el.tabContent[key].classList.contains(ActionSwitchTab.HIDE)) {
            this.el.tabContent[key].classList.remove(ActionSwitchTab.HIDE);
        }
    }

    init() {
        this.el.tabSwitcher.addEventListener('click', (event) => {
            let target = event.target;
            if (target && target.classList.contains(ActionSwitchTab.ITEM)) {
                for (let i = 0; i < this.el.item.length; i++) {
                    this.el.item[i].classList.remove(ActionSwitchTab.ACTIVE)
                    if (target === this.el.item[i]) {
                        this.hideContent(0, this.el.tabContent)
                        this.showContent(i, this.el.tabContent);
                        target.classList.add(ActionSwitchTab.ACTIVE);
                    }
                }
            }
        });
    }
}

export {ActionSwitchTab};