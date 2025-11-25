const ball = document.getElementById("arrow-down");

let pos = 0;
let speed = 1.5; // vitesse du mouvement
let direction = 1; // 1 = descend, -1 = monte
const max = 50; // hauteur max du rebond

function animate() {
    pos += speed * direction;
    ball.style.transform = `translateY(${pos}px)`;

    // change de direction
    if (pos >= max || pos <= 0) {
        direction *= -1;
    }

    requestAnimationFrame(animate);
}

animate();