import {Action} from "./Action.js";
import {Elemental} from "./Elemental.js";

export class ActionCalculate extends Action {
    constructor() {
        super();
        this.element = new Elemental().getByKeys(['btnCalc', 'provider', 'result']);
        Object.freeze(this)
    }

    init() {
        this.element.btnCalc.addEventListener('click', () => {
            let result = 0;

            this.element.provider.forEach((provider) => {
                let providerSum = 0;

                provider.querySelectorAll('.service').forEach((service) => {
                    const taxInput = service.querySelector('input[type="text"][readonly]');
                    const tax = taxInput ? parseFloat(taxInput.value) : 0;
                    const multipliers = service.querySelectorAll('input[type="number"]');

                    let multiplierProduct = 1;
                    for (const input of multipliers) {
                        const val = parseFloat(input.value);
                        if (isNaN(val) || val <= 0) {
                            multiplierProduct = 0;
                            break;
                        }
                        multiplierProduct *= val;
                    }

                    providerSum += tax * multiplierProduct;
                });

                result += providerSum;
            });

            this.element.result.innerText = `${result.toFixed(2)}`;
        });
    };
}