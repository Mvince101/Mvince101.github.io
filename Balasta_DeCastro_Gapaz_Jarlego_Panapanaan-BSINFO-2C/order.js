document.addEventListener('DOMContentLoaded', (event) => {
    let previewContainer = document.querySelector('.products-preview');
    let previewBoxes = Array.from(previewContainer.querySelectorAll('.preview'));

    document.querySelectorAll('.products-container .product').forEach(product => {
        product.onclick = () => {
            previewContainer.style.display = 'flex';
            let name = product.getAttribute('data-name');
            previewBoxes.forEach(preview => {
                let target = preview.getAttribute('data-target');
                if (name === target) {
                    preview.classList.add('active');
                } else {
                    preview.classList.remove('active');
                }
            });
        };
    });

    previewBoxes.forEach(close =>{
        close.querySelector('.fa-times').onclick = () =>{
            close.classList.remove('active');
            previewContainer.style.display = 'none';
        };
    });

    const menu = document.querySelector("#menu-icon");
    const navlist = document.querySelector('.navlist');
    const closeIcon = document.querySelector("#close-icon");

    menu.addEventListener("click", () => {
        navlist.classList.toggle("open");
    });

    closeIcon.addEventListener("click", () => {
        navlist.classList.remove("open");
    });
});


const header = document.querySelector("header");
const menuBtn = document.querySelector("#menu-btn");
const closeMenuBtn = document.querySelector("#close-menu-btn");

menuBtn.addEventListener("click", () => {
    header.classList.toggle("show-mobile-menu");
});

closeMenuBtn.addEventListener("click", () => {
    menuBtn.click();
});


