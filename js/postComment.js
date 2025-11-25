function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function controleInput(name, email, commentaire) {
    if (name.length < 1) {
        createClassiqueModale("Merci de renseignez notre nom")
        return false
    }

    const valideEmail = validateEmail(email)
    if (!valideEmail) {
        createClassiqueModale("Email invalide ! Merci de corriger votre saisie")
        return false
    }

    if (commentaire.length < 1) {
        createClassiqueModale("Vous essayez de déposer un commentaire mais avec un commentaire c'est encore mieux !")
        return false
    }

    return true
}



const btn = document.getElementById("btn-submit");

btn.addEventListener("click", function (e) {
    e.preventDefault()

    const nom = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const commentaire = document.getElementById("commentaire").value;

    console.log(nom)
    const validate = controleInput(nom, email, commentaire)

    if (!validate) return

    fetch("./../traitement_comment.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `nom=${encodeURIComponent(nom)}&email=${encodeURIComponent(email)}&commentaire=${encodeURIComponent(commentaire)}`
    })
        .then(r => r.ok ? console.log("Commentaire envoyé") : alert("Erreur serveur"))
        .then(() => {
            createClassiqueModale(`<div>
                        <p style="margin-bottom:8px">Merci d'avoir déposé votre commentaire. </p>
                        <p>
                            Pour garantir un espace respectueux et agréable à tous, les commentaires inappropriés, 
                            injurieux ou irrespectueux ne seront pas affichés.
                        </p>
                        </div>`)

            $("#name").val("");
            $("#email").val("");
            $("#commentaire").val("");
        })
})

