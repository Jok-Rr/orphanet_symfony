'use strict';

//! OWL CAROUSEL !\\


$(document).ready(function () {
  const html = document.documentElement
  const writingDirection = html.dir

  console.log(writingDirection);
  if (writingDirection == 'rtl') {

    $(".owl-carousel").owlCarousel({

      center: true,
      margin: 30,
      dotsContainer: '#carousel-custom-dots',
      dots: true,
      rtl: true,
      dotsData: true,
      responsive: {
        0: {
          items: 1.3,
        },
        800: {
          items: 3.3,
        },
        1500: {
          items: 4.3,
        }
      }
    });
  } else {
    $(".owl-carousel").owlCarousel({

      center: true,
      margin: 30,
      dotsContainer: '#carousel-custom-dots',
      dots: true,
      dotsData: true,
      responsive: {
        0: {
          items: 1.3,
        },
        800: {
          items: 3.3,
        },
        1500: {
          items: 4.3,
        }
      }
    });
  }

  $('.owl-next').click(function () {
    $(".owl-carousel").trigger('next.owl.carousel');
  })

  // Go to the previous item
  $('.owl-prev').click(function () {
    // With optional speed parameter
    // Parameters has to be in square bracket '[]'
    $(".owl-carousel").trigger('prev.owl.carousel', [300]);
  })


	loadLatestTweet(10, "niteshluharuka");



});

//! SCROLL NAVBAR SYST !\\

const home = document.getElementById('home');
const navbar = document.getElementById('nav-container');

// OnScroll event handler
const onScroll = () => {
  // Get scroll value
  const scroll = document.documentElement.scrollTop

  // If scroll value is more than 0 - add class
  if (scroll >= 100) {
    navbar.classList.add("header-scroll");
  } else {
    navbar.classList.remove("header-scroll")
  }
}

if (home) {
  window.addEventListener('scroll', onScroll)
} else {
  navbar.classList.add("header-scroll");
}

//! ShareMedia Syst !\\

const url = window.location.href;

const shareLink_Facebook = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
const shareLink_Twitter = `https://twitter.com/intent/tweet?url=${url}`;
const shareLink_Linkedin = `https://www.linkedin.com/shareArticle?mini=true&url=${url}`;

const fb = document.getElementById('sharelink-Facebook');
const twt = document.getElementById('sharelink-Twitter');
const lkd = document.getElementById('sharelink-Linkedin');

if (fb && twt && lkd) {
  fb.href = shareLink_Facebook;
  twt.href = shareLink_Twitter;
  lkd.href = shareLink_Linkedin;
}


//! NavMenu Mobil Syst !\\

const btnBurger = document.getElementById('toggle-btn');
const containerLinks = document.getElementById('mobile-nav-links');

btnBurger.addEventListener('click', () => {
  document.documentElement.classList.toggle('hidden');
  containerLinks.classList.toggle('open');
  btnBurger.classList.toggle('fa-xmark');
  console.log('Open Menu Mobile');
})



//! TWITTER FEED !\\



String.prototype.parseURL = function() {  
  return this.replace(/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&~\?\/.=]+/g, function(url) {  
     return url.link(url);  
  });  
};  
String.prototype.parseUsername = function() {  
  return this.replace(/[@]+[A-Za-z0-9-_]+/g, function(u) {  
     var username = u.replace("@","")  
     return u.link("http://twitter.com/"+username);  
  });  
};  
String.prototype.parseHashtag = function() {  
  return this.replace(/[#]+[A-Za-z0-9-_]+/g, function(t) {  
     var tag = t.replace("#","%23")  
     return t.link("http://search.twitter.com/search?q="+tag);  
  });  
};  
function parseDate(str) {  
  var v=str.split(' ');  
  return new Date(Date.parse(v[1]+" "+v[2]+", "+v[5]+" "+v[3]+" UTC"));  
}  
function loadLatestTweet(numTweets, un){  
  var _url = 'https://api.twitter.com/1/statuses/user_timeline/' + un + '.json?callback=?&count='+numTweets+'&include_rts=1';  
  $.getJSON(_url,function(data){  
     for(var i = 0; i< data.length; i++){  
        var tweet = data[i].text;  
        var created = parseDate(data[i].created_at);  
        var createdDate = created.getDate()+'-'+(created.getMonth()+1)+'-'+created.getFullYear()+' at '+created.getHours()+':'+created.getMinutes();  
        //Uncomment below line to see the user Image  
        //tweet = "<img src='"+data[i].user.profile_image_url+"' />";  
        tweet = tweet.parseURL().parseUsername().parseHashtag();  
        //Uncomment below line to displ tweet date.  
        //tweet += '<div class="tweeter-info"><p class="right">'+createdDate+'</p></div>'  
        $("#twitter-feed").append('<p>'+tweet+'</p>');  
     }  
  });  
}  