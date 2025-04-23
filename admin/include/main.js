// JS pour gérer AJAX et affichage
document.addEventListener("DOMContentLoaded", function () {
  // Gestion de l'envoi de formulaire d'événement
  const eventForm = document.getElementById("eventForm");
  if (eventForm) {
    eventForm.addEventListener("submit", async function (e) {
      e.preventDefault();
      const formData = new FormData(eventForm);
      const res = await fetch("api/addEvent.php", {
        method: "POST",
        body: formData
      });
      const txt = await res.text();
      alert(txt);
      window.location.reload();
    });
  }

  // Affichage des événements
  const evenementList = document.getElementById("evenementList");
  if (evenementList) {
    fetch("api/getEvents.php")
      .then(res => res.json())
      .then(data => {
        data.forEach(ev => {
          const card = document.createElement("div");
          card.className = "col-md-4";
          card.innerHTML = `
            <div class="card">
              ${ev.image ? `<img src="uploads/${ev.image}" class="card-img-top">` : ""}
              <div class="card-body">
                <h5 class="card-title">${ev.titre}</h5>
                <p class="card-text">${ev.description}</p>
                <p class="card-text"><small class="text-muted">${ev.date_evenement}</small></p>
              </div>
            </div>
          `;
          evenementList.appendChild(card);
        });
      });
  }

  // Connexion
  const loginForm = document.getElementById("loginForm");
  if (loginForm) {
    loginForm.addEventListener("submit", async function (e) {
      e.preventDefault();
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;

      const res = await fetch("api/connexion.php", {
        method: "POST",
        body: JSON.stringify({ email, password })
      });
      const result = await res.json();
      if (result.status === "success") {
        window.location.href = "evenements.php";
      } else {
        alert("Identifiants incorrects");
      }
    });
  }

  // Inscription
  const registerForm = document.getElementById("registerForm");
  if (registerForm) {
    registerForm.addEventListener("submit", async function (e) {
      e.preventDefault();
      const nom = document.getElementById("nom").value;
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;

      const res = await fetch("api/register.php", {
        method: "POST",
        body: JSON.stringify({ nom, email, password })
      });
      const txt = await res.text();
      alert(txt);
      window.location.href = "connexion.php";
    });
  }
});





