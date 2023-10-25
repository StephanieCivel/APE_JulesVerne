document.addEventListener('DOMContentLoaded', () => {
  // ton code dedans

  document.getElementById("myFormulaire").addEventListener("submit", function(event) {
    event.preventDefault(); // Empêche l'envoi du formulaire par défaut

    const formData = new FormData(this);

    fetch("https://stephaniecivel.sites.3wa.io/APE_JulesVerne/public/api", {
        method: "POST",
        body: formData
      })
      .then(response => {
        if (!response.ok) {
          throw new Error("Erreur lors de la requête.");
        }
        return response.text(); // Vous pouvez utiliser response.json() si vous attendez une réponse JSON
      })
      .then(data => {
        // Faites quelque chose avec la réponse du serveur (par exemple, afficher un message de confirmation)
        console.log("Réponse du serveur : " + data);
        if (data == true) {
          // "écrire dans le html"
        }
      })
      .catch(error => {
        console.error("Erreur : " + error.message);
      });
  });


  //MENU BURGER//
  "use strict";
  /* MENU */
  const LeMenu = document.getElementById("LeMenu");
  const CmdMenu = document.getElementById("CmdMenu");

  console.log(cmdMenu)
  CmdMenu.addEventListener('click', function() {
    console.log('clic')
    LeMenu.style.display = (LeMenu.style.display == 'none') ? '' : 'none';
  });
  // au chargement de la page
  window.onload = function() {
    // on teste la largeur de la fenêtre
    var ww = window.innerWidth; // en pixels
    LeMenu.style.display = (ww > 768) ? '' : 'none';
    CmdMenu.style.display = (ww > 768) ? 'none' : '';
  };
  // au redimensionnement de la fenêtre
  window.onresize = function() {
    // on teste la largeur de la fenêtre
    var ww = window.innerWidth; // en pixels
    LeMenu.style.display = (ww > 768) ? '' : 'none';
    CmdMenu.style.display = (ww > 768) ? 'none' : '';
  };
})
//CAROUSEL//
// Ceci est une fonction auto - exécutable.Les fonctions auto - exécutables
// sont des fonctions qui s'exécutent immédiatement après leur déclaration,
// sans avoir besoin d'être appelées.Les accolades immédiatement après la 
// déclaration de la fonction et les parenthèses à la fin de la déclaration 
// définissent la fonction et permettent de l'exécuter immédiatement.
(function () {
    // Utilisation de la directive "use strict" pour activer le mode strict en JavaScript
    // Cela implique une meilleure gestion des erreurs et une syntaxe plus stricte pour le code
    "use stict"
    // Déclare la constante pour la durée de chaque slide
    const slideTimeout = 5000;
    // Récupère les boutons de navigation
    const prev = document.querySelector('#prev');
    const next = document.querySelector('#next');
    // Récupère tous les éléments de type "slide"
    const $slides = document.querySelectorAll('.slide');
    // Initialisation de la variable pour les "dots"
    let $dots;
    // Initialisation de la variable pour l'intervalle d'affichage des slides
    let intervalId;
    // Initialisation du slide courant à 1
    let currentSlide = 1;
    // Fonction pour afficher un slide spécifique en utilisant un index
    function slideTo(index) {
        // Vérifie si l'index est valide (compris entre 0 et le nombre de slides - 1)
        currentSlide = index >= $slides.length || index < 1 ? 0 : index;
        // Boucle sur tous les éléments de type "slide" pour les déplacer
        $slides.forEach($elt => $elt.style.transform = `translateX(-${currentSlide * 100}%)`);
        // Boucle sur tous les "dots" pour mettre à jour la couleur par la classe "active" ou "inactive"
        $dots.forEach(($elt, key) => $elt.classList = `dot ${key === currentSlide? 'active': 'inactive'}`);
    }
    // Fonction pour afficher le prochain slide
    function showSlide() {
        slideTo(currentSlide);
        currentSlide++;
    }
    // Boucle pour créer les "dots" en fonction du nombre de slides
    for (let i = 1; i <= $slides.length; i++) {
        let dotClass = i == currentSlide ? 'active' : 'inactive';
        let $dot = `<span data-slidId="${i}" class="dot ${dotClass}"></span>`;
        document.querySelector('.carousel-dots').innerHTML += $dot;
    }
    // Récupère tous les "dots"
    $dots = document.querySelectorAll('.dot');
    // Boucle pour ajouter des écouteurs d'événement "click" sur chaque "dot"
    $dots.forEach(($elt, key) => $elt.addEventListener('click', () => slideTo(key)));
    // Ajout d'un écouteur d'événement "click" sur le bouton "prev" pour afficher le slide précédent
    prev.addEventListener('click', () => slideTo(--currentSlide))
    // Ajout d'un écouteur d'événement "click" sur le bouton "next" pour afficher le slide suivant
    next.addEventListener('click', () => slideTo(++currentSlide))
    // Initialisation de l'intervalle pour afficher les slides
    intervalId = setInterval(showSlide, slideTimeout)
    // Boucle sur tous les éléments de type "slide" pour ajouter des écouteurs d'événement pour les interactions avec la souris et le toucher
    $slides.forEach($elt => {
        let startX;
        let endX;
        // Efface l'intervalle d'affichage des slides lorsque la souris passe sur un slide
        $elt.addEventListener('mouseover', () => {
            clearInterval(intervalId);
        }, false)
        // Réinitialise l'intervalle d'affichage des slides lorsque la souris sort d'un slide
        $elt.addEventListener('mouseout', () => {
            intervalId = setInterval(showSlide, slideTimeout);
        }, false);
        // Enregistre la position initiale du toucher lorsque l'utilisateur touche un slide
        $elt.addEventListener('touchstart', (event) => {
            startX = event.touches[0].clientX;
        });
        // Enregistre la position finale du toucher lorsque l'utilisateur relâche son doigt
        $elt.addEventListener('touchend', (event) => {
            endX = event.changedTouches[0].clientX;
            // Si la position initiale est plus grande que la position finale, affiche le prochain slide
            if (startX > endX) {
                slideTo(currentSlide + 1);
                // Si la position initiale est plus petite que la position finale, affiche le slide précédent
            } else if (startX < endX) {
                slideTo(currentSlide - 1);
            }
        });
    })
})()
