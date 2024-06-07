document.addEventListener('DOMContentLoaded', () => {

const videos = document.querySelectorAll('video');


const togglePlayVideo = (video, shouldPlay) => {
    if(shouldPlay) return video.play();

    video.pause();
    video.currentTime = 0;
}

const toggleClassOnSlide = (video, isIntersecting) => {
    const slide = video.closest('.slide');
    if (isIntersecting) {
        slide.classList.add('in-view');
    } else {
        slide.classList.remove('in-view');
    }
};

const options = { root: null, rootMargin: '0px', threshold: 1 }

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        togglePlayVideo(entry.target, entry.isIntersecting);
        toggleClassOnSlide(entry.target, entry.isIntersecting);
    });
}, options);

videos.forEach(target => observer.observe(target))






/* Hamburger menu */
const hamburger = document.getElementById('hamburger');
const curtainMenu = document.getElementById('curtain-menu');
const curtainMenuContent = document.querySelector('.curtain-menu-content');
if (hamburger && curtainMenu && curtainMenuContent) {
    hamburger.addEventListener('click', function() {
        this.classList.toggle('toggle');
        curtainMenu.classList.toggle('invisible');
        curtainMenu.classList.toggle('opacity-0');
        curtainMenuContent.classList.toggle('!translate-x-0');
        document.body.classList.toggle('overflow-hidden');
    });
}

/* Scroll to the next section */
const scrollIcons = document.querySelectorAll('.scroll-icon');
const slides = document.querySelectorAll('.slide');

scrollIcons.forEach((icon, index) => {
    icon.addEventListener('click', () => {
      console.log("clicked");
        if (index < slides.length - 1) {
            slides[index + 1].scrollIntoView({ behavior: 'smooth' });
        } 
    });
});


/* Share button */
const shareBtn = document.querySelectorAll(".share-btn");
const shareOptions = document.querySelectorAll(".share-options");

shareBtn.forEach((item, index) => {
    shareBtn[index].addEventListener("click", function () {
      shareOptions[index].style.display = shareOptions[index].style.display === 'none' ? 'flex' : 'none';
    });
  });
  
  shareOptions.forEach((options, index) => {
    options.addEventListener("click", function (event) {
      if (event.target.tagName !== 'BUTTON' && event.target.tagName !== 'I') return;
  
      const postId = options.closest('.slide').getAttribute('data-post-id');
      const shareType = event.target.closest('.share-option').getAttribute('data-share-type');
      const postUrl = window.location.href.split('#')[0]; // Assuming each post is on a separate page
      const postTitle = document.title;
  
      switch (shareType) {
        case 'facebook':
          window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(postUrl)}`, '_blank');
          break;
        case 'twitter':
          window.open(`https://twitter.com/intent/tweet?url=${encodeURIComponent(postUrl)}&text=${encodeURIComponent(postTitle)}`, '_blank');
          break;
        case 'email':
          window.location.href = `mailto:?subject=${encodeURIComponent(postTitle)}&body=${encodeURIComponent(postUrl)}`;
          break;
        case 'copy':
          navigator.clipboard.writeText(postUrl).then(() => {
            alert('Link copied to clipboard');
          });
          break;
      }
    });
  });


}); // end dom load







