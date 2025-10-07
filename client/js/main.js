document.addEventListener("DOMContentLoaded", () => {
    let item = document.querySelectorAll('.item'),
        tabSwitcher = document.querySelector('.tab-switcher'),
        tabContent = document.querySelectorAll('.tab-content');

    function hideTabContent(a) {
        for (let i = a; i < tabContent.length; i++) {
            tabContent[i].classList.add('hide');
        }
    }

    hideTabContent(1);

    function showTabContent(b) {
        if (tabContent[b].classList.contains('hide')) {
            tabContent[b].classList.remove('hide');
        }
    }

    tabSwitcher.addEventListener('click', function(event) {
        let target = event.target;
        if (target && target.classList.contains('item')) {
            for(let i = 0; i < item.length; i++) {
                item[i].classList.remove('active')
                if (target === item[i]) {
                    hideTabContent(0);
                    showTabContent(i);
                    target.classList.add('active');
                }
            }
        }
    });
});