document.addEventListener('DOMContentLoaded', () => {
    // Contact Form
    let myForm = document.getElementById("myFormulaire")
    
    if (myForm !== null ) {
      myForm.addEventListener("submit", function (event) {
          event.preventDefault();
  
          const formData = new FormData(this);
  
          fetch("https://stephaniecivel.sites.3wa.io/APE_JulesVerne/public/api", {
              method: "POST",
              body: formData
          })
              .then(response => {
                  if (!response.ok) {
                      throw new Error("Erreur lors de la requête.");
                  }
                  return response.text();
              })
              .then(data => {
                  console.log("Réponse du serveur : " + data);
  
  
                  if (data) {
                      // "écrire dans le html"
                      let newDiv = document.createElement('div');
                      newDiv.classList.add('alert-success');
                      newDiv.innerText = 'Message reçu.'
                      document.body.appendChild(newDiv);
  
                      setTimeout(function () {
                          document.location.href = "https://stephaniecivel.sites.3wa.io/APE_JulesVerne/public/";
                      }, 3500)
                  }
              })
              .catch(error => {
                  console.error("Erreur : " + error.message);
              });
    });
    };


    // carousel
    const slideTimeout = 5000;
    const prev = document.querySelector('#prev');
    const next = document.querySelector('#next');
    const $slides = document.querySelectorAll('.slide');
    let $dots;
    let intervalId;
    let currentSlide = 1;

    function slideTo(index) {
        currentSlide = index >= $slides.length || index < 1 ? 0 : index;
        $slides.forEach($elt => $elt.style.transform = `translateX(-${currentSlide * 100}%)`);
        $dots.forEach(($elt, key) => $elt.classList = `dot ${key === currentSlide ? 'active' : 'inactive'}`);
    }

    function showSlide() {
        slideTo(currentSlide);
        currentSlide++;
    }

    for (let i = 1; i <= $slides.length; i++) {
        let dotClass = i == currentSlide ? 'active' : 'inactive';
        let $dot = `<span data-slidId="${i}" class="dot ${dotClass}"></span>`;
        document.querySelector('.carousel-dots').innerHTML += $dot;
    }

    $dots = document.querySelectorAll('.dot');

    $dots.forEach(($elt, key) => $elt.addEventListener('click', () => slideTo(key)));
    prev.addEventListener('click', () => slideTo(--currentSlide));
    next.addEventListener('click', () => slideTo(++currentSlide));
    intervalId = setInterval(showSlide, slideTimeout);

    $slides.forEach($elt => {
        let startX;
        let endX;

        $elt.addEventListener('mouseover', () => {
            clearInterval(intervalId);
        }, false);

        $elt.addEventListener('mouseout', () => {
            intervalId = setInterval(showSlide, slideTimeout);
        }, false);

        $elt.addEventListener('touchstart', (event) => {
            startX = event.touches[0].clientX;
        });

        $elt.addEventListener('touchend', (event) => {
            endX = event.changedTouches[0].clientX;

            if (startX > endX) {
                slideTo(currentSlide + 1);
            }
            else if (startX < endX) {
                slideTo(currentSlide - 1);
            }
        });
    });


    // BURGER MENU
    const icons = document.getElementById("navButton"); // Select the "icons" element
    const nav = document.getElementById("navMenu"); // Select the navigation menu with class "nav"

    icons.addEventListener("click", () => {
        icons.classList.toggle('active');
        nav.classList.toggle('active')
    });
});
