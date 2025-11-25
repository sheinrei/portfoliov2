

const nom = document.getElementById("name").getAttribute("value");
const email = document.getElementById("email").getAttribute("value");
const commentaire = document.getElementById("commentaire").getAttribute("value");

const btn = document.getElementById("btn-submit");

btn.addEventListener("click", function(e){
    e.preventDefault()
    console.log("click")
})