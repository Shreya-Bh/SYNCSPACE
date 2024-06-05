window.addEventListener('scroll', function() {
  var navbar = document.getElementById('navbar');
  if (window.scrollY > 0) {
    navbar.style.backgroundColor = 'rgba(0, 0, 0, 0.8)'; 
  } else {
    navbar.style.backgroundColor = 'transparent'; 
  }
});

document.getElementById('navbar-toggle').addEventListener('click', function() {
  document.getElementById('navbar-menu').classList.toggle('active');
});

function isInViewport(element, offset = 0) {
  var rect = element.getBoundingClientRect();
  return (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) + offset &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth) + offset
  );
}

function addAnimationOnScroll() {
  var paragraph = document.getElementById('animated-paragraph');
  var attendanceSection = document.querySelector('.attendance-section');
  if (isInViewport(paragraph, -200)) { 
    paragraph.classList.add('slide-in');
  }
  if (isInViewport(attendanceSection, 200)) { 
    attendanceSection.classList.add('slide-up');
  }
}

window.addEventListener('scroll', addAnimationOnScroll);

document.addEventListener('DOMContentLoaded', addAnimationOnScroll);
