
(function() {
  const homeArticle = document.querySelectorAll('.category-actualites');
  const countArticles = homeArticle.length;
  const newsContainer = document.querySelector('#news .container');
  console.log(countArticles);
  let newsColNbr='';
  if(countArticles===1){
    newsContainer.classList.add("news1col");
    newsColNbr =
        '.news1col {' +
          '-ms-grid-columns: 1fr !important;'+
          'grid-template-columns: 1fr !important;' +
        '}';
  }
  if(countArticles===2){
    newsContainer.classList.add("news2col");
    newsColNbr =
        '.news2col {' +
          '-ms-grid-columns: 1fr 1fr !important;'+
          'grid-template-columns: 1fr 1fr !important;' +
        '}';
  }

  // Create our stylesheet
  const style = document.createElement('style');
  style.innerHTML = newsColNbr;
  // Get the first script tag
  var ref = document.querySelector('script');

  // Insert our new styles before the first script tag
  ref.parentNode.insertBefore(style, ref);


})();



  // Fonction qui sera exécutée une fois que la page est complètement chargée
  function onPageLoaded() {
    // Vérifier si le div avec la classe "intro" existe dans la page
    const introDiv = document.querySelector('.intro');
  
    if (introDiv) {
      // Si le div "intro" existe, déplacer son contenu vers le div avec la classe "intro-text"
      const introTextDiv = document.querySelector('.intro-text');
      introTextDiv.appendChild(introDiv);
    }
  }

  // Attacher l'événement DOMContentLoaded à la fonction onPageLoaded
  document.addEventListener('DOMContentLoaded', onPageLoaded);