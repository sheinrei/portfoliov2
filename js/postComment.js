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
    const validate = controleInput(nom, email, commentaire)

    if (!validate) return

    fetch("../traitement_comment.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `nom=${encodeURIComponent(nom)}&email=${encodeURIComponent(email)}&commentaire=${encodeURIComponent(commentaire)}`
    })
        .then(r => r.ok ? (
            createClassiqueModale(`<div>
                        <p style="margin-bottom:8px">Commentaire déposé avec succès.</p>
                        <p>
                            Merci pour votre commentaire, une notification de la saisi vous a été envoyé par mail.
                        </p>
                        </div>`),

            $("#name").val(""),
            $("#email").val(""),
            $("#commentaire").val("")
        ) : createClassiqueModale("<div>Une erreur est survenu, votre message n'a pas pu être enregistré.</div>"))
       
})

