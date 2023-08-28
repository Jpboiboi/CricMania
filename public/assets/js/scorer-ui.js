const team1=document.querySelector('.toss-team1');
const team2=document.querySelector('.toss-team2');
const bat=document.querySelector('.toss-bat');
const bowl=document.querySelector('.toss-bowl');

team1.addEventListener('click',team1Toss);
team2.addEventListener('click',team2Toss);
bat.addEventListener('click',batToss);
bowl.addEventListener('click',bowlToss);

function team1Toss(evt){
    team1.style.backgroundColor="green";
    team2.style.backgroundColor="red";
    team1.style.color="white";
}
function team2Toss(evt){
    team1.style.backgroundColor="red";
    team2.style.backgroundColor="green";
    team2.style.color="white";
}
function batToss(evt){
    bowl.style.backgroundColor="red";
    bat.style.backgroundColor="green";
    bat.style.color="white";
}
function bowlToss(evt){
    bowl.style.backgroundColor="green";
    bat.style.backgroundColor="red";
    bowl.style.color="white";
}

