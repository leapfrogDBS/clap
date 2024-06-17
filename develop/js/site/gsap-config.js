document.addEventListener('DOMContentLoaded', function () {
   
  gsap.utils.toArray('.slide-up').forEach(item => {
    gsap.from(item, {
      y: 50, // Starting below its start position
      opacity: 0, // Starting from fully transparent
      duration: 1, // Animation takes 1 second
      ease: 'power1.out', // Easing function for a smooth effect
      scrollTrigger: {
        trigger: item,
        start: 'top 80%', // When the top of the item hits the 80% viewport height
        toggleActions: 'play none none none'
      }
    });
  });

 
}); // End of DOMContentLoaded
  
/* Use to rotate the image on the preloader */ 
gsap.to(".preloader-icon", {
  duration: 3,
  rotationY: 360,
  repeat: -1,
  ease: "linear"
}); 

window.addEventListener('load', function() {
  gsap.to("#preloader", {
      opacity: 0, 
      duration: 1,
      onComplete: function() {
          // Once the fade completes, set display to 'none'
          document.getElementById("preloader").style.display = "none";
      }
  });
});
  