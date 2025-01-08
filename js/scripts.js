document.addEventListener("DOMContentLoaded", function(e) {

  // universals + primitives

    const body = document.querySelector('body');
    const navFrame = document.querySelector('.site-navigation');
    const theHeader = document.querySelector('.site-header');

    const checkClass = (q,r) => {
      if(r.classList.contains(q)) {
        return true;
      } else {
        return false;
      }
    }

    const toggleClass = (q,r) => {
      if(checkClass(q,r)) {
        r.classList.remove(q);
      } else {
        r.classList.add(q);
      }
    }

    // const menuLanes = document.querySelectorAll('#menu-primary-nav .menu')

  // menu setups

    const mClass = 'mobile-menu-open';
    const mobMenu = document.querySelector('#main-navigation-toggle');

    const toggleMenu = () => {
      if(checkClass(mClass, body)) {
        body.classList.remove(mClass);
        navFrame.classList.remove('sub-open');
        mobMenu.setAttribute('aria-expanded', false);

      } else {
        if(theHeader.classList.contains('search-open')) theHeader.classList.remove('search-open');
        body.classList.add(mClass);
        mobMenu.setAttribute('aria-expanded', true);
      }
    }

    mobMenu.addEventListener('click', () => toggleMenu());

    document.querySelectorAll('#menu-primary-nav > li > button').forEach((btn, ndx) => {
      btn.addEventListener('click', () => {
        navFrame.setAttribute('data-active-sub-menu', ndx);
        if(window.innerWidth < 1200) {  // mobile action
          // alert('sup');
          toggleClass('sub-open', navFrame);
        } else {
          if( !btn.classList.contains('sub-menu-open')) {                    // full action
            if($curr = document.querySelector('#menu-primary-nav > li > button.sub-menu-open')) {
              $curr.classList.remove('sub-menu-open');
            }
            btn.setAttribute('aria-expanded', true);
          } else {
            btn.setAttribute('aria-expanded', false);
          }
          toggleClass('sub-menu-open', btn);
        }
      });
    });

    document.querySelectorAll('#menu-primary-nav .sub-menu > li:first-child').forEach((menu, ndx) => menu.insertAdjacentHTML('beforebegin', '<li><button class="icon-link arrow-west">Back</button></li>') );

    document.querySelectorAll('#menu-primary-nav .sub-menu > li > .arrow-west').forEach((bax, ndx) => {
      bax.addEventListener('click', () => {
        toggleClass('sub-open', navFrame);
      })
    })

  // search setup

    const toggleSearch = document.querySelector('.menu-utility button.menu-search');
    toggleSearch.addEventListener('click', () => {
      if(checkClass('search-open', theHeader)) {
        theHeader.classList.remove('search-open');
        toggleSearch.setAttribute('aria-expanded', false);
      } else {
        theHeader.classList.add('search-open');
        toggleSearch.setAttribute('aria-expanded', true);
        if(body.classList.contains(mClass)) body.classList.remove(mClass);
      }
    });

  // lightbox setup

    const lb = document.querySelector('#lb');

    function openLightbox() {
      lb.innerHTML += '<button aria-label="Close Lightbox" class="close-lb"><span></span><span></span></button>';
      document.querySelector('#lb .close-lb').addEventListener('click', closeLightbox, true);
      body.classList.add('lightbox-up');
      body.addEventListener('keyup', (e) => {
        if(e.key == 'Escape') closeLightbox();
      });
      lb.addEventListener('click', () => closeLightbox());
    }

    function closeLightbox() {
      document.querySelector('.close-lb').removeEventListener('click', closeLightbox, true);
      lb.innerHTML = "";
      body.classList.remove('lightbox-up');
      body.removeEventListener('keyup', () => {});
      lb.removeEventListener('click', () => closeLightbox());
    }

    function populateLightbox(core) {
      lb.innerHTML = '<div class="lb-plate">'+core+'</div>';
      openLightbox();
    }

    // video setup

    var tag = document.createElement('script');

    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    function ytID(url){
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
        var match = url.match(regExp);
        if ( match && match[7].length == 11 ){
            return match[7];
        } else {
            alert("Could not extract video ID.");
        }
    }

    // draw video
    function drawVideo(src) { // src must be YouTube url
      const id = ytID(src),
        embed = '<div id="video-frame" class="lb-video-frame"><iframe width="560" height="315" src="https://www.youtube.com/embed/'+id+'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>';

      return embed;
    }

    document.querySelectorAll('[data-video-url]').forEach((vid, ndx) => {

      vid.url = vid.getAttribute('data-video-url');

      vid.addEventListener('click', () => {
        populateLightbox(drawVideo(vid.url));
      });
    });
});
