
let  update_work_number_in_url = function() {
    let currentURL = document.location.href;
    let splitatquestion = currentURL.split('?');
    let newbase = splitatquestion[0];
    let workNumber = window.currentId;
    window.desiredWorkNumber = workNumber;
    let newURL = window.resourcepath+"art.php?category="+window.category+"&id="+workNumber;
    window.history.pushState('Jerry Frost', 'Jerry Frost', newURL);
}
let findWork=function() {
  let foundWork = null;
  // console.log('looking for: ' + window.currentId);
  for (let i =0; i < window.works.length; i++) {
    if ($(window.works[i]).data('id') == window.currentId) {
      foundWork = window.works[i];
    }
  }
  return foundWork;
}
let findWorkIndex = function(id) {
  foundIndex = 0;
  for (let i =0; i < window.works.length; i++) {
    if ($(window.works[i]).data('id') == id) {
      foundIndex = i;
    }
  }
  console.log('foundIndex == ' + foundIndex);
  return foundIndex;
}
let nextId=function() {
  let currentIndex = findWorkIndex(window.currentId);

  let nextIndex = currentIndex + 1;
  if (nextIndex >= window.works.length) {
    nextIndex = 0;
  }
  console.log('nextIndex=='+nextIndex);
  let nextId = $(window.works[nextIndex]).data('id');
  console.log('nextId=='+nextId);
  
  return nextId;
}

let prevId=function() {
  console.log('In Prev, current= ' + window.currentId);
  let currentIndex = findWorkIndex(window.currentId);
  console.log('In Prev, currentIndex: ' + currentIndex);
  let prevIndex = currentIndex - 1;
  console.log('In Prev, prevIndex: ' + prevIndex);
  if (prevIndex < 0) {
    prevIndex = window.works.length-1;
    console.log('In Prev, new prevIndex = ' + prevIndex);
  }
 
  let prevId = $(window.works[prevIndex]).data('id');

  return prevId;
}

let go_right = function() {
    window.currentId = nextId();
    window.currentWork = findWork();
    
    let index = findWorkIndex(window.currentId);
    let nextImage= $(window.works[index]).data('source');
    if (nextImage != '') {
      update_work_number_in_url();
      window.c1.find('img').attr('src',window.resourcepath+'uploads/artwork/' + nextImage);
      slideFit();
    } else {
      go_right();
    }
}


let go_left = function() {
  console.log('going left');
  window.currentId = prevId();
  console.log(window.currentId);
  window.currentWork = findWork();
  
  let index = findWorkIndex(window.currentId);
  let prevImage= $(window.works[index]).data('source');
  
  if (prevImage != '') {
    window.c1.find('img').attr('src','uploads/artwork/' + prevImage);
    update_work_number_in_url();
    slideFit();
  } else {
    go_left();
  }
  
}