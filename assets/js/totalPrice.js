"use strict";
window.addEventListener("load", () => {
    let totalPrice = 0;
    let elements = document.getElementsByClassName('price');

    this.addEventListener("change", () => {
        for (let element of elements) {
            let price = Number.parseFloat(element.innerHTML);
            if (price > 0) {
                totalPrice += price;
            }
        }
        document.getElementById("total-prices").value = totalPrice.toFixed(2);
        document.getElementById("total-prices").innerHTML = totalPrice.toFixed(2);

        totalPrice = null;
    });

    document.getElementById('redirectToShop').addEventListener("click", () => {
        window.location.href = window.location.origin;
    });

});

