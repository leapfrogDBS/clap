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
        const videos = document.querySelectorAll('video');

        const options = { root: null, rootMargin: '0px', threshold: 1 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                App.togglePlayVideo(entry.target, entry.isIntersecting);
                App.toggleClassOnSlide(entry.target, entry.isIntersecting);
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
        const slides = document.querySelectorAll('.slide');

        scrollIcons.forEach((icon, index) => {
            icon.addEventListener('click', () => {
                if (index < slides.length - 1) {
                    slides[index + 1].scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    },

    shareButtons: function () {
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
                const postUrl = window.location.href.split('#')[0];
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
    },

    init: function () {
        this.videoObserver();
        this.hamburgerMenu();
        this.scrollIcons();
        this.shareButtons();
    }
};

document.addEventListener("DOMContentLoaded", () => App.init());
