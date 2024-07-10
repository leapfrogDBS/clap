let App;

App = {
    debounce: function (func, wait, immediate) {
        let timeout;
        return function () {
            const context = this, args = arguments;
            const later = function () {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    },

    togglePlayVideo: function (video, shouldPlay) {
        if (shouldPlay) return video.play();
        video.pause();
        video.currentTime = 0;
    },

    toggleClassOnSlide: function (video, isIntersecting) {
        const slide = video.closest('.slide');
        if (isIntersecting) {
            slide.classList.add('in-view');
        } else {
            slide.classList.remove('in-view');
        }
    },

    videoObserver: function () {
        const videos = document.querySelectorAll('.slide video');

        const options = { root: null, rootMargin: '0px', threshold: 1 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                App.togglePlayVideo(entry.target, entry.isIntersecting);
                App.toggleClassOnSlide(entry.target, entry.isIntersecting);

                // Check and remove active class from share buttons
                const slide = entry.target.closest('.slide');
                const shareOptions = slide.querySelector('.share-options');
                if (!entry.isIntersecting && shareOptions) {
                    shareOptions.classList.remove('active');
                }
                
            });
        }, options);

        videos.forEach(target => observer.observe(target));

    },

    hamburgerMenu: function () {
        const hamburger = document.getElementById('hamburger');
        const curtainMenu = document.getElementById('curtain-menu');
        const curtainMenuContent = document.querySelector('.curtain-menu-content');

        if (hamburger && curtainMenu && curtainMenuContent) {
            hamburger.addEventListener('click', function () {
                this.classList.toggle('toggle');
                curtainMenu.classList.toggle('invisible');
                curtainMenu.classList.toggle('opacity-0');
                curtainMenuContent.classList.toggle('!translate-x-0');
                document.body.classList.toggle('overflow-hidden');
            });
        }
    },

    scrollIcons: function () {
        const scrollIcons = document.querySelectorAll('.scroll-icon');

        scrollIcons.forEach((icon, index) => {
            icon.addEventListener('click', () => {
                fullpage_api.moveSectionDown();
            });
        });
    },

    shareButtons: function () {
        const shareBtn = document.querySelectorAll(".share-btn");
        const shareOptions = document.querySelectorAll(".share-options");
    
        shareBtn.forEach((item, index) => {
            shareBtn[index].addEventListener("click", function () {
                shareOptions[index].classList.toggle('active');
                console.log(index);
            });
        });
    
        shareOptions.forEach((options, index) => {
            options.addEventListener("click", function (event) {
                if (event.target.tagName !== 'BUTTON' && event.target.tagName !== 'I') return;
    
                const postElement = options.closest('[data-post-id]');
                const postId = postElement.getAttribute('data-post-id');
                const postUrl = postElement.getAttribute('data-post-url'); // Use data-post-url attribute
                const postTitle = document.title; // or you can set it using postElement if available
    
                const shareType = event.target.closest('.share-option').getAttribute('data-share-type');
    
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
    },

    initFullpage: function() {
        if (document.querySelector('#fullpage')) {
            new fullpage('#fullpage', {
                licenseKey: '2KAM7-7L07I-MOK4J-C41J9-VVXRO',
                credits: { 
                    enabled: false, 
                },
            });
        }
    },
    

    init: function () {
        this.videoObserver();
        this.hamburgerMenu();
        this.scrollIcons();
        this.shareButtons();
        this.initFullpage();
    }
};

document.addEventListener("DOMContentLoaded", () => App.init());
