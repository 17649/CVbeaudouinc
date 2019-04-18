document.addEventListener("DOMContentLoaded", () => {

    const title = document.querySelector(".title");
    const background = document.querySelector("#background");
    const main = document.querySelector("main");
    const header = document.querySelector("header");

    const contactViewer = document.querySelector("#contact-viewer");

    const contact = document.querySelector("#contact");
    const formContact = contact.querySelector("form");
    const contactInfo = document.querySelector("#contact-info");
    const clearElement = (e) => {
        e.classList.add("cloud");
        e.classList.remove("padding-up");
    };

    document.querySelector("#open-contact").addEventListener("click", (e) => {
        document.querySelectorAll("section").forEach(clearElement);
        e.preventDefault();
        main.classList.add("cloud");
        header.classList.add("cloud");
        background.classList.add("blur");
        document.body.classList.add("modal-opened");
        contact.classList.add("modal-opened");
    });

    document.querySelector("#close-contact").addEventListener("click", () => {
        main.classList.remove("cloud");
        header.classList.remove("cloud");
        background.classList.remove("blur");
        document.body.classList.remove("modal-opened");
        contact.classList.remove("modal-opened");
    });

    document.querySelector("#send-contact").addEventListener("click", () => {
        if (formContact.reportValidity()) {
            fetch('', {method: 'POST', body: new FormData(formContact)}).then(r => {
                if (r.ok) {
                    contactInfo.innerText = "Message envoyée avec succès";
                    formContact.reset();
                } else {
                    r.text().then(d => contactInfo.innerText = d);
                }
            });
        }
    });

    document.querySelector("#view-contact").addEventListener("click", () => {
        const d = new FormData();
        d.append("password", prompt("Veuillez entrer votre mot de passe :"));
        fetch('', {method: 'POST', body: d}).then(r => {
            if (r.ok) {
                contact.classList.remove("modal-opened");
                contactViewer.classList.add("modal-opened");
                contactViewer.querySelectorAll(".contact-viewer-element").forEach(e => e.remove());
                r.json().then(j => j.forEach(c => {
                    const o = document.createElement("div");
                    o.classList.add("contact-viewer-element");
                    const months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
                        "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"];
                    const d = new Date(c.posted_at);
                    console.log(d);
                    o.innerHTML = `
                        <div class="contact-viewer-desc">
                          <span class="contact-viewer-desc-name">De : ${c.lastname} ${c.firstname} <span class="contact-viewer-desc-email">(${c.email})</span></span>
                          <span class="contact-viewer-desc-date">le ${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()} à ${d.getHours()}h${d.getMinutes()}</span>
                        </div>
                        <textarea readonly>${c.content}</textarea>
                    `;
                    contactViewer.appendChild(o);
                }))
            } else {
                alert("Erreur : entrée interdite.")
            }
        })
    });

    document.querySelector("#close-contact-viewer").addEventListener("click", () => {
        main.classList.remove("cloud");
        header.classList.remove("cloud");
        background.classList.remove("blur");
        document.body.classList.remove("modal-opened");
        contactViewer.classList.remove("modal-opened");
    });



    document.querySelectorAll("section").forEach(clearElement);

   window.addEventListener("hashchange", () => {
       document.querySelectorAll("section").forEach(clearElement);
       const id = decodeURI(window.location.hash);
       const e = document.querySelector(`${id}`);
       if (e !== null) {
           e.parentElement.classList.remove("cloud");
           if (id === "#compétences") {
               e.parentElement.nextElementSibling.classList.remove("cloud");
               e.parentElement.nextElementSibling.classList.add("padding-up");
           }
       }
   });

   window.addEventListener("scroll", ({pageY}) => {
       if (pageY > 100)
           title.classList.add("minimized");
       else
           title.classList.remove("minimized");
   });

});