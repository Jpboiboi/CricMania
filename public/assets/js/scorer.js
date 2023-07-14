//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
	if(animating) return false;
	animating = true;

	current_fs = $(this).parent();
	next_fs = $(this).parent().next();

	//activate next step on progressbar using the index of next_fs
	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

	//show the next fieldset
	next_fs.show();
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({
        'transform': 'scale('+scale+')',
        'position': 'absolute'
      });
			next_fs.css({'left': left, 'opacity': opacity});
		},
		duration: 800,
		complete: function(){
			current_fs.hide();
			animating = false;
		},
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;

	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();

	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

	//show the previous fieldset
	previous_fs.show();
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		},
		duration: 800,
		complete: function(){
			current_fs.hide();
			animating = false;
		},
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

// $('#scorer').on('shown.bs.modal', function () {
//     $('#myInput').trigger('focus')
//   });

document.getElementById("0").addEventListener('click', event);
document.getElementById("1").addEventListener('click', event);
document.getElementById("2").addEventListener('click', event);
document.getElementById("3").addEventListener('click', event);
document.getElementById("4").addEventListener('click', event);
document.getElementById("6").addEventListener('click', event);
document.getElementById("w").addEventListener('click', event);
document.getElementById("bye").addEventListener('click', event);
document.getElementById("lb").addEventListener('click', event);
document.getElementById("wide").addEventListener('click', event);



document.getElementById("nb").addEventListener('click', event);
document.getElementById("wide").addEventListener('click', event);
document.getElementById("undo").addEventListener('click', event);


document.getElementById("bye1").addEventListener('click',updateBye);
document.getElementById("bye2").addEventListener('click',updateBye);
document.getElementById("bye3").addEventListener('click',updateBye);
document.getElementById("bye4").addEventListener('click',updateBye);
document.getElementById("bye5").addEventListener('click',updateBye);
document.getElementById("bye6").addEventListener('click',updateBye);



document.getElementById("lby1").addEventListener('click',updateBye);
document.getElementById("lby2").addEventListener('click',updateBye);
document.getElementById("lby3").addEventListener('click',updateBye);
document.getElementById("lby4").addEventListener('click',updateBye);
document.getElementById("lby5").addEventListener('click',updateBye);
document.getElementById("lby6").addEventListener('click',updateBye);

// var byes = document.getElementById("selectByesModal").addEventListener('click', updateScore);





$(".card-body").click(function(e){
	e.target.classList.toggle("activecard");

})


var currentMatchOver = 0;
var currentOverBowl = 0;
var currentMatchBowl = currentMatchOver + '.' + currentOverBowl;
var currentRuns = 0;
var currentWicketsFallen = 0;
var totalNumbeOfovers = 5;

// console.log(liveScore);

function updateBye(e){
    // e.preventDefault();
    console.log(e.target);
    var byeRuns= parseInt(e.target.id.substr(3,4));
    // currentRuns = parseInt(byeRuns) + parseInt(currentRuns);
    // console.log(currentRuns);
    updateScore(parseInt(byeRuns));
    byeRuns = 0;
    console.log(byeRuns);
}

function event(e){
    updateScore(e.target.id);
}

function updateScore(score){
// console.log('hey');
    let currentBowl = score;
    // console.log(currentBowl);

    if(isFairDelivery(currentBowl))
    {
        if(isWicket(currentBowl)){
            currentWicketsFallen = parseInt(currentWicketsFallen) + 1;

        }

        if(Number.isInteger(parseInt(currentBowl))){
            currentRuns = parseInt(score) + parseInt(currentRuns);
        }

        if(currentOverBowl == 5){

            currentMatchOver = currentMatchOver + 1;
			currentOverBowl = 0;
        }

        // if(currentBowl == 'undo'){

        // }
        if(currentBowl == 'bye'){
            return;
        }

        if(currentBowl == 'lb'){
            return;
        }
        else {
            currentOverBowl = currentOverBowl + 1;
            // var bowlsix = 6;
        }

    }
    else
    {
        currentRuns = 1 + parseInt(currentRuns);
    }
    // console.log(currentRuns);
    var currentMatchBowl = currentMatchOver + '.' + currentOverBowl
    var liveScore = currentRuns + '/' + currentWicketsFallen + '(' + currentMatchBowl + '/' + totalNumbeOfovers + ')';
    console.log(currentRuns)
    let scoreholder = document.getElementById('score');
    scoreholder.innerHTML = `<h4>${currentRuns + '/' + currentWicketsFallen}</h4>
                            <h6 class="ms-2 mt-2">
                            ${'(' + currentMatchBowl + '/' + totalNumbeOfovers + ')'}
                            </h6>`;
    let bowl1 = document.getElementById('bowl1');
    let bowl2 = document.getElementById('bowl2');
    let bowl3 = document.getElementById('bowl3');
    let bowl4 = document.getElementById('bowl4');
    let bowl5 = document.getElementById('bowl5');
    let bowl6 = document.getElementById('bowl6');
    let bowltwo = document.getElementById('bowltwo');

    // console.log(currentMatchBowl);
    // console.log(currentOverBowl);

    if(currentOverBowl == 1){
        bowl1.innerHTML = `<h6>${currentBowl}</h6>`;
        bowl2.innerHTML = `<h6>0</h6>`;
        bowl3.innerHTML = `<h6>0</h6>`;
        bowl4.innerHTML = `<h6>0</h6>`;
        bowl5.innerHTML = `<h6>0</h6>`;
        bowl6.innerHTML = `<h6>0</h6>`;

    }

    if(currentOverBowl == 2){
        bowl2.innerHTML = `<h6 id="bowltwo">${currentBowl}</h6>`;
        // console.log(currentBowlwithoutno);


        if(currentBowl =='nb'){
            // bowl2.innerHTML=`<h6>${currentBowlwithoutno}Nb</h6>`;
            bowl2.innerHTML = `<h6 >${bowltwo}</h6>`;
        }
    }

    if(currentOverBowl == 3){
        bowl3.innerHTML = `<h6>${currentBowl}</h6>`;
    }

    if(currentOverBowl == 4){
        bowl4.innerHTML = `<h6>${currentBowl}</h6>`;
    }

    if(currentOverBowl == 5){
        bowl5.innerHTML = `<h6>${currentBowl}</h6>`;
        // var bowlsix = 6;
    }
    if(currentBowl == 'nb'){
        // console.log('hey');
        // console.log(currentOverBowl);
        // bowl{currentBowl}

    }
    // console.log(currentOverBowl);


    const arr = ['1.0', '2.0', '3.0', '4.0', '5.0'];
    // const arr2 = [1.0, 2.0, 3.0, 4.0, 5.0];
    // console.log(arr);
    // console.log(currentMatchBowl);
    if(arr.includes(currentMatchBowl)){
        bowl6.innerHTML = `<h6>${currentBowl}</h6>`;
    }

    function isWicket(currentBowl){
        if(currentBowl == 'w'){
            return true;
        }
        return false;
    }

    function isFairDelivery(currentBowl){
        // console.log(currentBowl);
        if(currentBowl == 'wide' || currentBowl == 'nb'){
            return false;
        }
        return true;
    }
}

