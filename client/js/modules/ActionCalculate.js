import {Action} from "./Action.js";

class ActionCalculate extends Action {
    static PROVIDER = "provider";

    init() {
        document.getElementById('btn-calc').addEventListener('click', () => {
            const providers = document.querySelectorAll('.provider');
            let result = 0;

            providers.forEach((provider, pIndex) => {
                let providerSum = 0;

                const services = provider.querySelectorAll('.service');
                services.forEach((service) => {
                    // Получаем тариф (readonly input с ценой)
                    const priceInput = service.querySelector('input[type="text"][readonly]');
                    const price = priceInput ? parseFloat(priceInput.value) : 0;

                    // Получаем все множители (input[type=number])
                    const multiplierInputs = service.querySelectorAll('input[type="number"]');

                    // Перемножаем все введённые значения множителей
                    let multiplierProduct = 1;
                    for (const input of multiplierInputs) {
                        const val = parseFloat(input.value);
                        if (isNaN(val) || val <= 0) {
                            multiplierProduct = 0; // если хотя бы одно поле не заполнено или 0, считаем услугу 0
                            break;
                        }
                        multiplierProduct *= val;
                    }

                    // Стоимость услуги = тариф * произведение множителей
                    const serviceCost = price * multiplierProduct;
                    providerSum += serviceCost;
                });

                console.log(`Провайдер #${pIndex + 1} - сумма: ${providerSum.toFixed(2)} ₽`);
                result += providerSum;
            });

            const res = document.getElementById("result")
            res.innerText = `${result.toFixed(2)} ₽`;
        });
    };
}

export {ActionCalculate};