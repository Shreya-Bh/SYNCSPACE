
const images = [
    'ai-generated-7998838_1920.jpg',
    'ai-generated-7998870_1920.jpg',
    'ai-generated-8181045_1920.jpg',
    'ai-generated-8205414_1920.jpg',
    'ai-generated-8224030_1920.jpg',
    'ai-generated-8306425_1920.jpg',
    'ai-generated-8313689_1920.jpg',
    'ai-generated-8317942_1920.jpg',
    'ai-generated-8317943_1920.jpg',
    'ai-generated-8332568_1920.jpg',
    'ai-generated-8332571_1920.jpg',
    'alien-8306415_1920.jpg',
    'cat-8191907_1920.png',

    'dog-8161639_1920.jpg',
    'tortoise-7713285_1920.jpg'

];


function getRandomImage() {
    const randomIndex = Math.floor(Math.random() * images.length);
    return '../MainProject/Media/' + images[randomIndex];
}


window.onload = function() {
    const img = document.getElementById('random-image');
    img.src = getRandomImage();
};



document.addEventListener('DOMContentLoaded', function() {

    document.getElementById('logoutBtn').addEventListener('click', function() {

        fetch('logout.php', {
            method: 'POST',
        })
        .then(response => {
            if (response.ok) {

                window.location.href = 'middle.html'; 
            } else {
                console.error('Logout failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
