"use strict"
window.addEventListener("load", () => {
    let mainMenuElements =
        document.getElementById("main-menu").getElementsByTagName('a');
    for (const element of mainMenuElements) {
        if (element.href === window.location.href)
            element.classList.add('active')
    }

    const tableElements =
        document.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    console.log(tableElements.length)

})
