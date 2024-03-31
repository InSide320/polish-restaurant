"use strict"
window.addEventListener("load", () => {
    let mainMenuElements = document.getElementById("main-menu").getElementsByTagName('a');
    for (const element of mainMenuElements) {
        if (element.href === window.location.href)
            element.classList.add('active')
    }
})
