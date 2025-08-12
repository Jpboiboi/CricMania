//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

//To maintain state of stepper
let fieldsets=document.getElementsByTagName('fieldset');
let progressbar=document.getElementById('progressbar');
let loader=document.getElementById("loader")
let toastModal=document.getElementById("error-toast")
let tournamentID=0;
let tournamentMatchID=0;

let mainURL=window.location.toLocaleString();
let wordsOfURL=mainURL.split('/');
let tournamentIndex=wordsOfURL.indexOf('tournaments');
let tournamentMatchIndex=wordsOfURL.indexOf('tournament_matches');

if(tournamentIndex!=-1 && tournamentMatchIndex!=-1){
    tournamentID=wordsOfURL[tournamentIndex+1]
    tournamentMatchID=wordsOfURL[tournamentMatchIndex+1]
}

const inningInput = document.getElementById('inning');
const inning = inningInput.value;
console.log(inning)

$( document ).ready(function() {
    fieldsets[0].style.display = "none";
    loader.style.display="block";
    // toastModal.style.display = "none";
    if(inning==="first"){
        checkFirstScreen();
    }else if(inning==="second"){
        progressbar.style.display="none";
        checkFourthScreen();
    }
});

function checkFirstScreen(){
    currentURL = `http://localhost:8000/api/tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/check-toss-and-election-status`;

    http.get(currentURL)
        .then(function(data){
            loader.style.display="none";
            fieldsets[0].style.display = "block";
            $("#progressbar li")[0].classList.add('active');
        })
        .catch(function(err){
            if(err.status == 409) {
                fieldsets[0].style.display = "none";
                $("#progressbar li")[1].classList.add('active');
                checkSecondScreen();
            }
        })
}

function checkSecondScreen() {
    currentURL = `http://localhost:8000/api/tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/check-playing-eleven-selection-status`;

    http.get(currentURL)
        .then(function(data){
            loader.style.display="none";
            fieldsets[1].style.display = "block";
            $("#progressbar li")[1].classList.add('active');
        })
        .catch(function(err){
            if(err.status == 409) {
                fieldsets[1].style.display = "none";
                $("#progressbar li")[2].classList.add('active');
                checkThirdScreen();
            }
        })
}

function checkThirdScreen(){
    currentURL = `http://localhost:8000/api/tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/check-players-roles-selection-status`;

    http.get(currentURL)
        .then(function(data){
            loader.style.display="none";
            fieldsets[2].style.display = "block";
            $("#progressbar li")[2].classList.add('active');
        })
        .catch(function(err){
            if(err.status == 409) {
                fieldsets[2].style.display = "none";
                $("#progressbar li")[3].classList.add('active');
                checkFourthScreen();
            }
        })
}

function checkFourthScreen() {
    currentURL = `http://localhost:8000/api/tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/check-match-scorcard-status?inning=${inning}`;

    http.get(currentURL)
        .then(function(data){
            loader.style.display="none";
            fieldsets[3].style.display = "block";
            $("#progressbar li")[3].classList.add('active');
        })
        .catch(function(err){
            if(err.status == 409) {
                document.location.href=`http://localhost:8000/tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/live-scoring?inning=${inning}`
            }
        })
}

function nextScreen(evt){

	if(animating) return false;
	animating = true;

	current_fs = $(evt.target).parent();
	next_fs = current_fs.next();

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
}

http=new slHTTP();

const screenOneNextBtn=document.getElementById('screenOneNextBtn');
const tossTeam1Btn=document.getElementById('updateTossTeam1');
const tossTeam2Btn=document.getElementById('updateTossTeam2');
const electedToBatBtn=document.getElementById('updateElectedToBat');
const electedToBowlBtn=document.getElementById('updateElectedToBowl');
const team1PlayersBtn=document.getElementById('team1Players');
const team2PlayersBtn=document.getElementById('team2Players');
const team1BattersElem=document.getElementById('team1Batters');
const team1BallersElem=document.getElementById('team1Ballers');
const team1AllroundersElem=document.getElementById('team1Allrounders');
const saveTeam1PlayingXI=document.getElementById('saveTeam1PlayingXI');
const team2BattersElem=document.getElementById('team2Batters');
const team2BallersElem=document.getElementById('team2Ballers');
const team2AllroundersElem=document.getElementById('team2Allrounders');
const saveTeam2PlayingXI=document.getElementById('saveTeam2PlayingXI');
const screenTwoNextBtn=document.getElementById('screenTwoNextBtn');
const strikerElem=document.getElementById('striker');
const nonStrikerElem=document.getElementById('nonStriker');
const bowlerElem=document.getElementById('bowler');
const setStrikerElem=document.getElementById('updateStriker');
const setNonStrikerElem=document.getElementById('updateNonStriker');
const setBowlerElem=document.getElementById('updateBowler');

const strikerNameElem=document.getElementById('strikerName');
const nonStrikerNameElem=document.getElementById('nonStrikerName');
const bowlerNameElem=document.getElementById('bowlerName');

const currentSelectedTeam1PlayersElem=document.getElementById('currentSelectedTeam1Players');
const currentSelectedTeam2PlayersElem=document.getElementById('currentSelectedTeam2Players');

const updateKeyPlayersOfTeam1Btn=document.getElementById('updateKeyPlayersOfTeam1');
const updateKeyPlayersOfTeam2Btn=document.getElementById('updateKeyPlayersOfTeam2');
const team1PlayingXIElem=document.getElementById('team1PlayingXI');
const team2PlayingXIElem=document.getElementById('team2PlayingXI');
const saveKeyPlayersOfTeam1Btn=document.getElementById('saveKeyPlayersOfTeam1');
const saveKeyPlayersOfTeam2Btn=document.getElementById('saveKeyPlayersOfTeam2');
const screenThreeNextBtn=document.getElementById('screenThreeNextBtn');

const strikerBattersInXIElem=document.getElementById('strikerBattersInXI');
const strikerBallersInXIElem=document.getElementById('strikerBallersInXI');
const strikerAllroundersInXIElem=document.getElementById('strikerAllroundersInXI');
const nonStrikerBattersInXIElem=document.getElementById('nonStrikerBattersInXI');
const nonStrikerBallersInXIElem=document.getElementById('nonStrikerBallersInXI');
const nonStrikerAllroundersInXIElem=document.getElementById('nonStrikerAllroundersInXI');
const battersInXIElem=document.getElementById('battersInXI');
const ballersInXIElem=document.getElementById('ballersInXI');
const allroundersInXIElem=document.getElementById('allroundersInXI');
const startScoringElem=document.getElementById("startScoring");

const team1ModalBody = document.getElementById('setTeam1Players')
const team2ModalBody = document.getElementById('setTeam2Players')

const errorToastBody = document.getElementById('error-toast-body')

const BASEURL='http://localhost:8000/api/';


let tossWinner=0;
let electedTo="";
let strikerBatsmanID=0;
let nonStrikerBatsmanID=0;
let bowlerID=0;

let team1CaptainID="";
let team2CaptainID="";
let team1ViceCaptainID="";
let team2ViceCaptainID="";
let team1WicketKeeperID="";
let team2WicketKeeperID="";


let strikerBatsmanName="";
let nonStrikerBatsmanName="";
let bowlerName="";

let team1PlayingEleven="";
let team2PlayingEleven="";

tossTeam1Btn.addEventListener('click',updateTossID);
tossTeam2Btn.addEventListener('click',updateTossID);
electedToBatBtn.addEventListener('click',updateElectedTo);
electedToBowlBtn.addEventListener('click',updateElectedTo);
screenOneNextBtn.addEventListener('click',updateToss);
team1PlayersBtn.addEventListener('click',getTeam1Players);
team2PlayersBtn.addEventListener('click',getTeam2Players);

updateKeyPlayersOfTeam1Btn.addEventListener('click',getTeam1PlayingXI);
updateKeyPlayersOfTeam2Btn.addEventListener('click',getTeam2PlayingXI);

saveKeyPlayersOfTeam1Btn.addEventListener('click',saveKeyPlayersOfTeam1);
saveKeyPlayersOfTeam2Btn.addEventListener('click',saveKeyPlayersOfTeam2);
screenThreeNextBtn.addEventListener('click',updateKeyPlayersOfBothTeams);

saveTeam1PlayingXI.addEventListener('click',saveTeam1Players);
saveTeam2PlayingXI.addEventListener('click',saveTeam2Players);
screenTwoNextBtn.addEventListener('click',setPlayingXIofBothTeams);
strikerElem.addEventListener('click',getStrikersInXI);
nonStrikerElem.addEventListener('click',getNonStrikersInXI);
bowlerElem.addEventListener('click',getBallingTeamsPlayingXI);
setStrikerElem.addEventListener('click',setStriker);
setNonStrikerElem.addEventListener('click',setNonStriker);
setBowlerElem.addEventListener('click',setBowler);
startScoringElem.addEventListener('click',startScoring);
team1ModalBody.addEventListener('click', countOfTeam1Players)
team2ModalBody.addEventListener('click', countOfTeam2Players)
// Added by Dipesh
team1PlayingXIElem.addEventListener('click', disableSiblings)
team2PlayingXIElem.addEventListener('click', disableSiblings)

function updateTossID(evt){
    if(evt.target.parentElement.dataset.toss!=undefined){
        tossWinner=evt.target.parentElement.dataset.toss;
    }else if(evt.target.parentElement.parentElement.dataset.toss!=undefined){
        tossWinner=evt.target.parentElement.parentElement.dataset.toss;
    }
    console.log(tossWinner);
}

function updateElectedTo(evt){
    if(evt.target.parentElement.dataset.elected_to!=undefined){
        electedTo=evt.target.parentElement.dataset.elected_to;
    }else if(evt.target.parentElement.parentElement.dataset.elected_to!=undefined){
        electedTo=evt.target.parentElement.parentElement.dataset.elected_to;
    }
    console.log(electedTo);
}

function updateToss(evt){
    tournamentID=evt.target.dataset.tournament_id;
    tournamentMatchID=evt.target.dataset.tournament_match_id;
    const data={
        toss:tossWinner,
        elected_to:electedTo
    }
    const requestHeaders={
        'Content-Type':'application/json'
    };
    console.log(data);
    let currentURL=BASEURL+`tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/update`;
    console.log(currentURL);

    http.put(currentURL,data,requestHeaders)
        .then(function(data){
            console.log(data);
            nextScreen(evt);
        })
        .catch(function(err){
            const errJson = err.json();
            errJson
                .then((errObj) => {
                    toastModal.style.display = "block";
                    errorToastBody.textContent = errObj.error
                    setTimeout(() => {
                        toastModal.style.display = "none";
                        errorToastBody.textContent = ""
                    }, 3000);
                })
            console.warn(err);
        })
}

function getTeam1Players(evt){
    let currentURL=BASEURL+`tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/team1-players`;

    http.get(currentURL)
        .then(function(data){
            let batters="";
            let ballers="";
            let allrounders="";

            [batters,ballers,allrounders]=renderDataWithCheckBox(data,"team1Players");

            if(team1BattersElem.innerHTML=="" && team1BallersElem.innerHTML=="" && team1AllroundersElem.innerHTML=="" ){
                team1BattersElem.innerHTML+=batters;
                team1BallersElem.innerHTML+=ballers;
                team1AllroundersElem.innerHTML+=allrounders;
            }
        })
        .catch(function(err){
            console.warn(err);
        })
}

function getTeam2Players(evt){
    let currentURL=BASEURL+`tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/team2-players`;

    http.get(currentURL)
        .then(function(data){
            let batters="";
            let ballers="";
            let allrounders="";

            [batters,ballers,allrounders]=renderDataWithCheckBox(data,"team2Players");

            if(team2BattersElem.innerHTML=="" && team2BallersElem.innerHTML=="" && team2AllroundersElem.innerHTML=="" ){
                team2BattersElem.innerHTML+=batters;
                team2BallersElem.innerHTML+=ballers;
                team2AllroundersElem.innerHTML+=allrounders;
            }
        })
        .catch(function(err){
            console.warn(err);
        })
}

function countOfTeam1Players(evt) {
    let checkboxes = document.getElementsByName('team1Players');
    updateCount(checkboxes,currentSelectedTeam1PlayersElem,saveTeam1PlayingXI);
}

function countOfTeam2Players(evt) {
    let checkboxes = document.getElementsByName('team2Players');
    updateCount(checkboxes,currentSelectedTeam2PlayersElem,saveTeam2PlayingXI);
}

// Changed By Dipesh
function updateCount(checkboxes,elem,btn){
    count = 0;
    for (var i=0; i<checkboxes.length; i++) {
        if (checkboxes[i].type == "checkbox" && checkboxes[i].checked == true){
            count++;
        }
    }
    elem.innerHTML=count;
    if(count<11){
        elem.parentElement.classList.add('text-warning');
        elem.parentElement.classList.remove('text-success');
        elem.parentElement.classList.remove('text-danger');
        btn.disabled=true;
        for (var i=0; i<checkboxes.length; i++) {
            if (checkboxes[i].type == "checkbox" && checkboxes[i].checked == false){
                checkboxes[i].disabled=false;
            }
        }
    }else if(count==11){
        elem.parentElement.classList.remove('text-warning');
        elem.parentElement.classList.add('text-success');
        elem.parentElement.classList.remove('text-danger');
        btn.disabled=false;
        for (var i=0; i<checkboxes.length; i++) {
            if (checkboxes[i].type == "checkbox" && checkboxes[i].checked == false){
                checkboxes[i].disabled=true;
            }
        }
    }else if(count>11){
        elem.parentElement.classList.remove('text-warning');
        elem.parentElement.classList.remove('text-success');
        elem.parentElement.classList.add('text-danger');
        btn.disabled=true;
    }
}

function saveTeam1Players(evt){
    let checkboxes = document.getElementsByName('team1Players');
    for (let i=0, n=checkboxes.length;i<n;i++)
    {
        if (checkboxes[i].checked)
        {
            team1PlayingEleven+= checkboxes[i].value+",";
        }
    }
    team1PlayingEleven = team1PlayingEleven.substring(0, team1PlayingEleven.length - 1);
}

function saveTeam2Players(evt){
    let checkboxes = document.getElementsByName('team2Players');
    for (let i=0, n=checkboxes.length;i<n;i++)
    {
        if (checkboxes[i].checked)
        {
            team2PlayingEleven+= checkboxes[i].value+",";
        }
    }
    team2PlayingEleven = team2PlayingEleven.substring(0, team2PlayingEleven.length - 1);
}

function setPlayingXIofBothTeams(evt){
    const data={
        team1_playing_eleven:team1PlayingEleven,
        team2_playing_eleven:team2PlayingEleven
    }
    const requestHeaders={
        'Content-Type':'application/json'
    };
    console.log(data);
    let currentURL=BASEURL+`tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/set-playing-eleven-players`;
    console.log(currentURL);

    http.put(currentURL,data,requestHeaders)
        .then(function(data){
            console.log(data)
            nextScreen(evt)
        })
        .catch(function(err){
            const errJson = err.json();
            errJson
                .then((errObj) => {
                    toastModal.style.display = "block";
                    errorToastBody.textContent += errObj.error
                    setTimeout(() => {
                        toastModal.style.display = "none";
                        errorToastBody.textContent = ""
                    }, 3000);
                })
        })
}

function getTeam1PlayingXI(evt){
    evt.preventDefault();
    let currentURL=BASEURL+`tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/team1-players?playing_eleven=true`;
    http.get(currentURL)
        .then(function(data){
            let output=renderDataForKeyPlayers(data);
            if(team1PlayingXIElem.innerHTML===""){
                team1PlayingXIElem.innerHTML=output;
            }
        })
        .catch(function(err){
            console.warn(err);
        })
}

function getTeam2PlayingXI(evt){
    evt.preventDefault();
    let currentURL=BASEURL+`tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/team2-players?playing_eleven=true`;

    http.get(currentURL)
        .then(function(data){
            let output=renderDataForKeyPlayers(data);
            if(team2PlayingXIElem.innerHTML===""){
                team2PlayingXIElem.innerHTML=output;
            }
        })
        .catch(function(err){
            console.warn(err);
        })
}

function saveKeyPlayersOfTeam1(evt){
    [team1CaptainID,team1ViceCaptainID,team1WicketKeeperID]=getSelectedKeyPlayers();
    // Removed By Dipesh
    // disableSiblings();
    console.log(team1CaptainID);
    console.log(team1ViceCaptainID);
    console.log(team1WicketKeeperID);
}


function saveKeyPlayersOfTeam2(evt){
    [team2CaptainID,team2ViceCaptainID,team2WicketKeeperID]=getSelectedKeyPlayers();
    // Removed By Dipesh
    // disableSiblings();
    console.log(team2CaptainID);
    console.log(team2ViceCaptainID);
    console.log(team2WicketKeeperID);
}

// Changed By Dipesh
function disableSiblings()
{
    const captainRadios = document.querySelectorAll('.c-radio');

    captainRadios.forEach(captainRadio => {
        captainRadio.addEventListener('click', () => {
            const row = captainRadio.closest('tr');
            const vcRadio = row.querySelector('.vc-radio');
            vcRadio.checked = false;
        });
    });

    const viceCaptainRadios = document.querySelectorAll('.vc-radio');

    viceCaptainRadios.forEach(viceCaptainRadio => {
        viceCaptainRadio.addEventListener('click', () => {
            const row = viceCaptainRadio.closest('tr');
            const cRadio = row.querySelector('.c-radio');
            cRadio.checked = false;
        });
    });
}

function getSelectedKeyPlayers(){
    let cRadioBtns = document.getElementsByName('c');
    let vcRadioBtns=document.getElementsByName('vc');
    let wkRadioBtns=document.getElementsByName('wk');
    let cID="";
    let vcID="";
    let wkID="";
    for (let i=0, n=cRadioBtns.length;i<n;i++)
    {
        if (cRadioBtns[i].checked)
        {
            cID = `${cRadioBtns[i].value}`;
        }
        if(vcRadioBtns[i].checked)
        {
            vcID=`${vcRadioBtns[i].value}`;
        }
        if(wkRadioBtns[i].checked)
        {
            wkID=`${wkRadioBtns[i].value}`;
        }
    }
    return [cID,vcID,wkID];
}

function updateKeyPlayersOfBothTeams(evt){
    evt.preventDefault();
    const data={
        team1_captain_id:team1CaptainID,
        team2_captain_id:team2CaptainID,
        team1_vice_captain_id:team1ViceCaptainID,
        team2_vice_captain_id:team2ViceCaptainID,
        team1_wicket_keeper_id:team1WicketKeeperID,
        team2_wicket_keeper_id:team2WicketKeeperID
    }
    const requestHeaders={
        'Content-Type':'application/json'
    };
    console.log(data);
    let currentURL=BASEURL+`tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/set-players-roles`;
    console.log(currentURL);

    http.put(currentURL,data,requestHeaders)
        .then(function(data){
            console.log(data);
            nextScreen(evt)
        })
        .catch(function(err){
            const errJson = err.json();
            errJson
                .then((errObj) => {
                    toastModal.style.display = "block";
                    errorToastBody.textContent = errObj.error
                    setTimeout(() => {
                        toastModal.style.display = "none";
                        errorToastBody.textContent = ""
                    }, 3000);
                })
        })
}

function getStrikersInXI(evt){
    let currentURL=BASEURL+`tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/batting-team-players`;

    http.get(currentURL)
        .then(function(data){
            let batters="";
            let ballers="";
            let allrounders="";

            [batters,ballers,allrounders]=renderDataWithRadio(data,"team1PlayersRadio");


            if(strikerBattersInXIElem.innerHTML=="" && strikerBallersInXIElem.innerHTML=="" && strikerAllroundersInXIElem.innerHTML=="" ){
                strikerBattersInXIElem.innerHTML+=batters;
                strikerBallersInXIElem.innerHTML+=ballers;
                strikerAllroundersInXIElem.innerHTML+=allrounders;
            }
        })
        .catch(function(err){
            console.warn(err);
        })
}

function getNonStrikersInXI(evt){
    let currentURL=BASEURL+`tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/batting-team-players`;

    http.get(currentURL)
        .then(function(data){
            let batters="";
            let ballers="";
            let allrounders="";

            [batters,ballers,allrounders]=renderDataWithRadio(data,"team1PlayersRadio");


            if(nonStrikerBattersInXIElem.innerHTML=="" && nonStrikerBallersInXIElem.innerHTML=="" && nonStrikerAllroundersInXIElem.innerHTML=="" ){
                nonStrikerBattersInXIElem.innerHTML+=batters;
                nonStrikerBallersInXIElem.innerHTML+=ballers;
                nonStrikerAllroundersInXIElem.innerHTML+=allrounders;
            }
        })
        .catch(function(err){
            console.warn(err);
        })
}

function setStriker(){
    let radioBtns = document.getElementsByName('team1PlayersRadio');
    for (let i=0, n=radioBtns.length;i<n;i++)
    {
        if (radioBtns[i].checked)
        {

            strikerBatsmanID = radioBtns[i].value;
            strikerBatsmanName=radioBtns[i].dataset.playername;
        }
    }
    console.log(strikerBatsmanID);
    strikerNameElem.innerHTML=strikerBatsmanName;
}

function setNonStriker(){
    let radioBtns = document.getElementsByName('team1PlayersRadio');
    for (let i=0, n=radioBtns.length;i<n;i++)
    {
        if (radioBtns[i].checked)
        {
            if(strikerBatsmanID!=radioBtns[i].value){
                nonStrikerBatsmanID = radioBtns[i].value;
                nonStrikerBatsmanName=radioBtns[i].dataset.playername;
            }else{
                console.log("Striker NonStriker cannot be same")
            }
        }
    }
    console.log(nonStrikerBatsmanID);
    nonStrikerNameElem.innerHTML=nonStrikerBatsmanName;
}

function getBallingTeamsPlayingXI(evt){
    let currentURL=BASEURL+`tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/bowling-team-players`;

    http.get(currentURL)
        .then(function(data){
            let batters="";
            let ballers="";
            let allrounders="";
            [batters,ballers,allrounders]=renderDataWithRadio(data,"playersRadio");


            if(battersInXIElem.innerHTML=="" && ballersInXIElem.innerHTML=="" && allroundersInXIElem.innerHTML=="" ){
                battersInXIElem.innerHTML+=batters;
                ballersInXIElem.innerHTML+=ballers;
                allroundersInXIElem.innerHTML+=allrounders;
            }
        })
        .catch(function(err){
            console.warn(err);
        })
}

function setBowler(){
    let radioBtns = document.getElementsByName('playersRadio');
    for (let i=0, n=radioBtns.length;i<n;i++)
    {
        if (radioBtns[i].checked)
        {
            bowlerID = radioBtns[i].value;
            bowlerName=radioBtns[i].dataset.playername;
        }
    }
    console.log(bowlerID);
    bowlerNameElem.innerHTML=bowlerName;
}

function startScoring(evt){
    evt.preventDefault();
    const data={
        strike_batsman_id: strikerBatsmanID,
        non_strike_batsman_id: nonStrikerBatsmanID,
        bowler_id: bowlerID,
        inning: inning // Changed by Dipesh
    }
    console.log(data)

    const requestHeaders={
        'Content-Type':'application/json'
    };

    console.log(data);

    let currentURL=BASEURL+`tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/match_scorecards`;
    console.log(currentURL);

    http.post(currentURL,data,requestHeaders)
        .then(function(data){
            console.log(data);
            //Changed by Dipesh
            document.location.href=`http://localhost:8000/tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/scoring`
            // document.location.href=`http://localhost:8000/tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/live-scoring?inning=${inning}`
        })
        .catch(function(err){
            const errJson = err.json();
            errJson
                .then((errObj) => {
                    toastModal.style.display = "block";
                    errorToastBody.textContent = errObj.error
                    setTimeout(() => {
                        toastModal.style.display = "none";
                        errorToastBody.textContent = ""
                    }, 3000);
                })
        })
}

//Helper Functions
function renderDataWithCheckBox(data,name){
    let batters="";
    let ballers="";
    let allrounders="";

    data.data.forEach(function(player){
        if(player.specialization==="batsman"){
            batters+=`
                <div class="card mt-1 mb-1">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" name=${name} type="checkbox" value="${player.id}" id="player_${player.id}">
                            <label class="form-check-label" for="player_${player.id}">
                                ${player.slug} <span class="text-muted">(${player.batting_hand} handed)</span>
                            </label>
                        </div>
                    </div>
                </div>
            `;
        }else if(player.specialization==="all-rounder"){
            allrounders+=`
                <div class="card mt-1 mb-1">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" name=${name} type="checkbox" value="${player.id}" id="player_${player.id}">
                            <label class="form-check-label" for="player_${player.id}">
                            ${player.slug} <span class="text-muted">(${player.batting_hand} handed/
                            ${player.balling_type})</span>
                            </label>
                        </div>
                    </div>
                </div>
            `;
        }else if(player.specialization==="baller"){
            ballers+=`
                <div class="card mt-1 mb-1">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" name=${name} type="checkbox" value="${player.id}" id="player_${player.id}">
                            <label class="form-check-label" for="player_${player.id}">
                                ${player.slug} <span class="text-muted">(${player.balling_hand} hand
                                ${player.balling_type})</span>
                            </label>
                        </div>
                    </div>
                </div>
            `;
        }
    });

    return [batters,ballers,allrounders];
}

function renderDataWithRadio(data,name){
    let batters="";
    let ballers="";
    let allrounders="";

    data.data.forEach(function(player){
        if(player.specialization==="batsman"){
            batters+=`
                <div class="card mt-1 mb-1">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" name=${name} type="radio" data-playername="${player.slug}" value="${player.id}" id="player_${player.id}">
                            <label class="form-check-label" for="player_${player.id}">
                                ${player.slug} <span class="text-muted">(${player.batting_hand} handed)</span>
                            </label>
                        </div>
                    </div>
                </div>
            `;
        }else if(player.specialization==="all-rounder"){
            allrounders+=`
                <div class="card mt-1 mb-1">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" name=${name} type="radio" data-playername="${player.slug}" value="${player.id}" id="player_${player.id}">
                            <label class="form-check-label" for="player_${player.id}">
                            ${player.slug} <span class="text-muted">(${player.batting_hand} handed/
                            ${player.balling_type})</span>
                            </label>
                        </div>
                    </div>
                </div>
            `;
        }else if(player.specialization==="baller"){
            ballers+=`
                <div class="card mt-1 mb-1">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" name=${name} type="radio" data-playername="${player.slug}" value="${player.id}" id="player_${player.id}">
                            <label class="form-check-label" for="player_${player.id}">
                                ${player.slug} <span class="text-muted">(${player.balling_hand} hand
                                ${player.balling_type})</span>
                            </label>
                        </div>
                    </div>
                </div>
            `;
        }
    });

    return [batters,ballers,allrounders];
}

function renderDataForKeyPlayers(data){
    let output="";
            let count=1;
            data.data.forEach(function(player){
                output+=`
                <tr>
                    <th scope="row">${count}</th>
                    <td>${player.slug}</td>
                    <td>
                        <input type="radio" class="c-radio" name="c" value="${player.id}"/>
                    </td>
                    <td>
                        <input type="radio" class="vc-radio" name="vc" value="${player.id}"/>
                    </td>
                    <td>
                        <input type="radio" class="wk-radio" name="wk" value="${player.id}"/>
                    </td>
              </tr>`;
              count++;
            });
    return output;
}
