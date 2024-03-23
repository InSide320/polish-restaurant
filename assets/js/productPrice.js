"use strict"
let elements = document.getElementsByClassName('input');
window.addEventListener("load", () => {

    if (elements) {
        for (let elementsKey of elements) {
            console.log(elementsKey);
            elementsKey.addEventListener("change", (event) => {
                let element = event.target;
                let countElement = element.value;
                let parentElement = element.parentElement;
                let productPrice =
                    parentElement.getElementsByClassName('price-product')[0].value;
                let priceElement = parentElement.getElementsByClassName('price')[0];
                let sumProduct = productPrice * countElement;
                sumProduct = sumProduct.toFixed(2);
                priceElement.innerHTML = sumProduct + "zł";
            });
        }
    }
});

