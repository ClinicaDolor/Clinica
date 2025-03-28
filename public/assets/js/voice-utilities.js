    // Pre-cargar las voces para que estén disponibles
    let voicesLoaded = false;
    function preloadVoices() {
      const voices = speechSynthesis.getVoices();
      if (voices.length > 0) {
        voicesLoaded = true;
        //console.log("Voces pre-cargadas");
      }
    }
    preloadVoices();
    speechSynthesis.onvoiceschanged = preloadVoices;

    let currentUtterance = null;
    let currentSectionId = null;

    function leerTextoSeccion(sectionId) {
      // Si se pulsa el botón de la misma sección que se está reproduciendo, detenerla
      if (currentSectionId === sectionId && speechSynthesis.speaking) {
        speechSynthesis.cancel();
        currentSectionId = null;
        const textoElement = document.querySelector(`#${sectionId} .texto`);
        if (textoElement) {
          textoElement.innerText = textoElement.getAttribute('data-original') || textoElement.innerText;
        }
        return;
      }

      // Si hay otra reproducción en curso, cancelarla y restaurar el texto de la sección anterior
      if (speechSynthesis.speaking) {
        speechSynthesis.cancel();
        if (currentSectionId) {
          const prevTexto = document.querySelector(`#${currentSectionId} .texto`);
          if (prevTexto) {
            prevTexto.innerText = prevTexto.getAttribute('data-original') || prevTexto.innerText;
          }
        }
      }

      const section = document.getElementById(sectionId);
      if (!section) {
        console.error("Sección no encontrada:", sectionId);
        return;
      }
      const textoElement = section.querySelector(".texto");
      if (!textoElement) {
        console.error("Elemento de texto no encontrado en la sección:", sectionId);
        return;
      }
      const originalText = textoElement.innerText.trim();
      textoElement.setAttribute('data-original', originalText);
      if (!originalText) {
        console.error("No hay texto para leer en la sección:", sectionId);
        return;
      }

      const utterance = new SpeechSynthesisUtterance(originalText);
      utterance.lang = "es-ES";
      utterance.rate = 1;
      utterance.pitch = 1;

      // Forzar el uso de voz en español si está disponible
      const voces = speechSynthesis.getVoices();
      const vozEspañol = voces.find(voz => voz.name.includes("Google Español") || voz.lang.includes("es"));
      if (vozEspañol) {
        utterance.voice = vozEspañol;
      }

      currentSectionId = sectionId;
      currentUtterance = utterance;

      // Actualizar el resaltado letra a letra mediante onboundary
      utterance.onboundary = function(event) {
        const index = event.charIndex;
        const spokenPart = originalText.slice(0, index);
        const remainingPart = originalText.slice(index);
        textoElement.innerHTML = `<span class="highlightText">${spokenPart}</span>${remainingPart}`;
      };

      utterance.onend = function() {
        currentSectionId = null;
        currentUtterance = null;
        textoElement.innerText = originalText;
      };

      function iniciarReproduccion() {
        window.speechSynthesis.speak(utterance);
      }
      if (voicesLoaded) {
        iniciarReproduccion();
      } else {
        speechSynthesis.onvoiceschanged = () => {
          voicesLoaded = true;
          iniciarReproduccion();
        };
      }
    }

    // Botón para repetir manualmente
    document.querySelectorAll('.btnLeer').forEach(button => {
      button.addEventListener('click', function() {
        const target = this.getAttribute('data-target');
        leerTextoSeccion(target);
      });
    });

    // Intersection Observer para detectar cuando la sección se visualiza
    const observerOptions = {
      root: null,
      rootMargin: "0px",
      threshold: 0.5 // Se considera visible cuando al menos el 50% es visible
    };

    const observerCallback = (entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const section = entry.target;
          // Se reproduce automáticamente si data-autoplay es "false"
          if (section.getAttribute('data-autoplay') === "false") {
            const sectionId = section.id;
            leerTextoSeccion(sectionId);
            section.setAttribute('data-autoplay', "true"); // Solo se reproduce una vez por recarga
          }
        }
      });
    };

    const observer = new IntersectionObserver(observerCallback, observerOptions);
    document.querySelectorAll('.sectionQuestion').forEach(section => {
      observer.observe(section);
    });