const inputs = document.querySelectorAll(".input");
const dropdowns = document.querySelectorAll(".input-dropdown");
const toggle_btn = document.querySelectorAll(".toggle");
const main = document.querySelector("main");
const bullets = document.querySelectorAll(".bullets span");
const images = document.querySelectorAll(".image");

let currentIndex = 0;


inputs.forEach(inp => {
    inp.addEventListener("focus", () => {
        inp.classList.add("active");
    });
    inp.addEventListener("blur", () => {
        if (inp.value !== "") return;
        inp.classList.remove("active");
    });
});


dropdowns.forEach(dropdown => {
    dropdown.addEventListener("focus", () => {
        dropdown.classList.add("active");
    });
    dropdown.addEventListener("blur", () => {
        if (dropdown.value !== "") return;
        dropdown.classList.remove("active");
    });
    dropdown.addEventListener("change", () => {
        if (dropdown.value !== "") {
            dropdown.classList.add("active");
        } else {
            dropdown.classList.remove("active");
        }
    });
});


toggle_btn.forEach((btn) => {
    btn.addEventListener("click", () => {
        main.classList.toggle("sign-up-mode");
    });
});


function moveSlider(index) {
    let currentImage = document.querySelector(`.img-${index + 1}`);
    images.forEach(img => img.classList.remove("show"));
    currentImage.classList.add("show");

    const textSlider = document.querySelector(".text-group");
    textSlider.style.transform = `translateY(${-(index) * 2.1}rem)`;

    bullets.forEach(bull => bull.classList.remove("active"));
    bullets[index].classList.add("active");
}


bullets.forEach((bullet, index) => {
    bullet.addEventListener("click", () => {
        currentIndex = index;
        moveSlider(index);
    });
});


function autoSlide() {
    currentIndex = (currentIndex + 1) % images.length;
    moveSlider(currentIndex);
}


setInterval(autoSlide, 3000); 

function fetchDepartments() {
    fetch('sign-up.php') 
        .then(response => response.json())
        .then(data => {
            const departmentSelect = document.getElementById('department');
            departmentSelect.innerHTML = ''; 
            const placeholderOption = document.createElement('option');
            placeholderOption.value = "";
            placeholderOption.selected = true;
            placeholderOption.disabled = true;
            placeholderOption.hidden = true;
            departmentSelect.appendChild(placeholderOption); 

            data.departments.forEach(dept => {
                const option = document.createElement('option');
                option.value = dept;
                option.text = dept;
                departmentSelect.appendChild(option);
            });

            
            departmentSelect.dispatchEvent(new Event('change'));
        })
        .catch(error => console.error('Error fetching departments:', error));
}


window.addEventListener('load', fetchDepartments);
