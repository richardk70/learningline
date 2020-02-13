const dropCont = document.getElementsByClassName('drop-content')[0];
const nav = document.getElementsByTagName('nav')[0];
const front = document.getElementsByClassName('front')[0];

window.addEventListener('scroll', (e) => {
    let scrollUp = this.oldScroll > this.scrollY;
    this.oldScroll = this.scrollY;
    if (scrollUp){
        console.log('scrooling up');
      front.style.top = 100 + 'px';
    }
    if (!scrollUp){ // while scrolling down
      front.style.top = -10 + 'px';
      nav.style.opacity = 1.0;
      //document.getElementById('best').style.top = -50 + 'px';
    }
    if (document.documentElement.scrollTop < 20) {
        nav.style.top = 0 + 'px';
    } else {
        nav.style.top = -100 + 'px';
    }
    // if (window.innerWidth < 725)
    // front.style.top = 0 + 'px';
  });

// NAVIGATION ////////////////////////////////////////////////
const Ahome = document.getElementById('Ahome');
const Aabout = document.getElementById('Aabout');
const Aservices = document.getElementById('Aservices');
const Alocation = document.getElementById('Alocation');
const Acontact = document.getElementById('Acontact');
const Apolicies = document.getElementById('Apolicies');

dropCont.addEventListener('click', (e) => {
  console.log(e.target);
  switch (e.target.id){
    case 'nav-home': scrollHome();
    break;
    case 'nav-about': scrollAbout();
    break;
    case 'nav-services': scrollServices();
    break;
    case 'nav-location': scrollLocation();
    break;
    case 'nav-contact': scrollContact();
    break;
    case 'nav-policies': scrollPolicies();
    break;
  }
});

function scrollHome(){
  scrollToResolver(Ahome);
}

function scrollAbout(){
  scrollToResolver(Aabout);
}

function scrollServices(){
  scrollToResolver(Aservices);
}
function scrollLocation(){
  scrollToResolver(Alocation);
}
function scrollContact(){
  scrollToResolver(Acontact);
}
function scrollPolicies(){
  scrollToResolver(Apolicies);
}

function scrollToResolver(elem){
  var jump = parseInt(elem.getBoundingClientRect().top * .05);
  document.body.scrollTop += jump;
  document.documentElement.scrollTop += jump;
  if (!elem.lastjump || elem.lastjump >= Math.abs(jump)) {
    elem.lastjump = Math.abs(jump);
    setTimeout(function() { scrollToResolver(elem);}, "20");
  } else {
    elem.lastjump = null;
  }
}