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
  
 
  