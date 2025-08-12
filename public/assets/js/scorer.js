// $('#scorer').on('shown.bs.modal', function () {
//     $('#myInput').trigger('focus')
//   });
http=new slHTTP();
let matchScoredCard;
let matchScoredCardID=0;
let tournamentID=0;
let tournamentMatchID=0;
let overStatsLoaderHTML = `<div class="col-md-1 loading-circle"><span id="over-stats-loader" class="ms-3 mb-5"></span></div>`;
let mainURL=window.location.toLocaleString();
let wordsOfURL=mainURL.split('/');
let tournamentIndex=wordsOfURL.indexOf('tournaments');
let tournamentMatchIndex=wordsOfURL.indexOf('tournament_matches');

if(tournamentIndex!=-1 && tournamentMatchIndex!=-1){
    tournamentID=wordsOfURL[tournamentIndex+1]
    tournamentMatchID=wordsOfURL[tournamentMatchIndex+1]
}

// const queryString = window.location.search;
// const urlParams = new URLSearchParams(queryString);
// const inning = urlParams.get('inning')
const inningInput = document.getElementById('inning');
const inning = inningInput.value;
const BASEURL='http://localhost:8000/api/';

$(document).ready(function(){
    currentOverDetailsElem.innerHTML = overStatsLoaderHTML;

    currentURL = `http://localhost:8000/api/tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/match_scorecards?inning=${inning}`;
    http.get(currentURL)
        .then(function(data){
            console.log(data);
            matchScoredCard = data.data;
            matchScoredCardID=data.data.id;
            updateScreen(data.data)
            addEventListenersOnButtons();
        })
        .catch(function(err){
            console.log(err)
        })
});

{
// document.getElementById("dot").addEventListener('click', eventRun);
// document.getElementById("single").addEventListener('click', eventRun);
// document.getElementById("double").addEventListener('click', eventRun);
// document.getElementById("triple").addEventListener('click', eventRun);
// document.getElementById("four").addEventListener('click', eventRun);
// document.getElementById("six").addEventListener('click', eventRun);
// // document.getElementById("w").addEventListener('click', event);
// // document.getElementById("bye").addEventListener('click', event);
// // document.getElementById("lb").addEventListener('click', event);
// // document.getElementById("wide").addEventListener('click', event);

// // document.getElementById("nb").addEventListener('click', event);
// // document.getElementById("wide").addEventListener('click', event);
// document.getElementById("undo").addEventListener('click', undoPreviousBall);

// document.getElementById("bye1").addEventListener('click',updateByes);
// document.getElementById("bye2").addEventListener('click',updateByes);
// document.getElementById("bye3").addEventListener('click',updateByes);
// document.getElementById("bye4").addEventListener('click',updateByes);
// document.getElementById("bye5").addEventListener('click',updateByes);
// document.getElementById("bye6").addEventListener('click',updateByes);

// document.getElementById("lby1").addEventListener('click',updateLegByes);
// document.getElementById("lby2").addEventListener('click',updateLegByes);
// document.getElementById("lby3").addEventListener('click',updateLegByes);
// document.getElementById("lby4").addEventListener('click',updateLegByes);
// document.getElementById("lby5").addEventListener('click',updateLegByes);
// document.getElementById("lby6").addEventListener('click',updateLegByes);

// document.getElementById('changeStriker').addEventListener('click',getStrikersInXI);
// document.getElementById('changeNonStriker').addEventListener('click',getNonStrikersInXI);
// document.getElementById('changeBowler').addEventListener('click',getBowlersInXI);
// document.getElementById('updateStriker').addEventListener('click',setStriker);
// document.getElementById('updateNonStriker').addEventListener('click',setNonStriker);
// document.getElementById('updateBowler').addEventListener('click',setBowler);

// document.getElementById('noBallRunsBtn').addEventListener('click',updateNoBallRuns);
// document.getElementById('outOnNB').addEventListener('click',updateNBAndShowBatsmenOnCrease);
// document.getElementById('noWicketOnNB').addEventListener('click',updateStatusOfWicketOnNB);
// document.getElementById('noBallNextBtn1').addEventListener('click',getOutBatsmanAndBallingTeamXI);
// document.getElementById('noBallNextBtn2').addEventListener('click',getWhoDidRunOut);

// document.getElementById('outOnWD').addEventListener('click',updateStatusOfWicketOnWD);
// document.getElementById('noWicketOnWD').addEventListener('click',updateStatusOfWicketOnWD);
// document.getElementById('wideBallRunsBtn').addEventListener('click',updateWideBallRuns);
// document.getElementById('stumpedOnWD').addEventListener('click',updateWicketOnWD);
// document.getElementById('hitWicketOnWD').addEventListener('click',updateWicketOnWD);
// document.getElementById('runOutOnWD').addEventListener('click',updateBatsmenOnCrease);
// document.getElementById('wideBallNextBtn1').addEventListener('click',getOutBatsmanAndBallingTeamXIWD);
// document.getElementById('wideBallNextBtn2').addEventListener('click',getWhoDidRunOut);



// document.getElementById('bowled').addEventListener('click',updateBowledWicket);
// document.getElementById('lbw').addEventListener('click',updateLbwWicket);
// document.getElementById('hitWicket').addEventListener('click',updateHitWicket);
// document.getElementById('stumped').addEventListener('click',updateStumpedWicket);
// document.getElementById('caught').addEventListener('click',showBallingTeamXI);
// document.getElementById('caughtBy').addEventListener('click',updateCaughtByAndWicket);
// document.getElementById('runOut').addEventListener('click',showBatsmenOnCrease);
// document.getElementById('runOutNextBtn1').addEventListener('click',getOutBatsman);
// document.getElementById('runOutNextBtn2').addEventListener('click',getRunScoredAndShowBallingTeamXI);
// document.getElementById('runOutNextBtn3').addEventListener('click',updateRunOutWicket);
}

function addEventListenersOnButtons() {
    document.getElementById("dot").addEventListener('click', eventRun);
    document.getElementById("single").addEventListener('click', eventRun);
    document.getElementById("double").addEventListener('click', eventRun);
    document.getElementById("triple").addEventListener('click', eventRun);
    document.getElementById("four").addEventListener('click', eventRun);
    document.getElementById("six").addEventListener('click', eventRun);
    document.getElementById("undo").addEventListener('click', undoPreviousBall);

    document.getElementById("bye1").addEventListener('click',updateByes);
    document.getElementById("bye2").addEventListener('click',updateByes);
    document.getElementById("bye3").addEventListener('click',updateByes);
    document.getElementById("bye4").addEventListener('click',updateByes);
    document.getElementById("bye5").addEventListener('click',updateByes);
    document.getElementById("bye6").addEventListener('click',updateByes);

    document.getElementById("lby1").addEventListener('click',updateLegByes);
    document.getElementById("lby2").addEventListener('click',updateLegByes);
    document.getElementById("lby3").addEventListener('click',updateLegByes);
    document.getElementById("lby4").addEventListener('click',updateLegByes);
    document.getElementById("lby5").addEventListener('click',updateLegByes);
    document.getElementById("lby6").addEventListener('click',updateLegByes);

    document.getElementById('changeStriker').addEventListener('click',getStrikersInXI);
    document.getElementById('changeNonStriker').addEventListener('click',getNonStrikersInXI);
    document.getElementById('changeBowler').addEventListener('click',getBowlersInXI);
    document.getElementById('updateStriker').addEventListener('click',setStriker);
    document.getElementById('updateNonStriker').addEventListener('click',setNonStriker);
    document.getElementById('updateBowler').addEventListener('click',setBowler);

    document.getElementById('noBallRunsBtn').addEventListener('click',updateNoBallRuns);
    document.getElementById('outOnNB').addEventListener('click',updateNBAndShowBatsmenOnCrease);
    document.getElementById('noWicketOnNB').addEventListener('click',updateStatusOfWicketOnNB);
    document.getElementById('noBallNextBtn1').addEventListener('click',getOutBatsmanAndBallingTeamXI);
    document.getElementById('noBallNextBtn2').addEventListener('click',getWhoDidRunOut);

    document.getElementById('outOnWD').addEventListener('click',updateStatusOfWicketOnWD);
    document.getElementById('noWicketOnWD').addEventListener('click',updateStatusOfWicketOnWD);
    document.getElementById('wideBallRunsBtn').addEventListener('click',updateWideBallRuns);
    document.getElementById('stumpedOnWD').addEventListener('click',updateWicketOnWD);
    document.getElementById('hitWicketOnWD').addEventListener('click',updateWicketOnWD);
    document.getElementById('runOutOnWD').addEventListener('click',updateBatsmenOnCrease);
    document.getElementById('wideBallNextBtn1').addEventListener('click',getOutBatsmanAndBallingTeamXIWD);
    document.getElementById('wideBallNextBtn2').addEventListener('click',getWhoDidRunOut);



    document.getElementById('bowled').addEventListener('click',updateBowledWicket);
    document.getElementById('lbw').addEventListener('click',updateLbwWicket);
    document.getElementById('hitWicket').addEventListener('click',updateHitWicket);
    document.getElementById('stumped').addEventListener('click',updateStumpedWicket);
    document.getElementById('caught').addEventListener('click',showBallingTeamXI);
    document.getElementById('caughtBy').addEventListener('click',updateCaughtByAndWicket);
    document.getElementById('runOut').addEventListener('click',showBatsmenOnCrease);
    document.getElementById('runOutNextBtn1').addEventListener('click',getOutBatsman);
    document.getElementById('runOutNextBtn2').addEventListener('click',getRunScoredAndShowBallingTeamXI);
    document.getElementById('runOutNextBtn3').addEventListener('click',updateRunOutWicket);
}

function removeEventListenersOnButtons() {
    document.getElementById("dot").removeEventListener('click', eventRun);
    document.getElementById("single").removeEventListener('click', eventRun);
    document.getElementById("double").removeEventListener('click', eventRun);
    document.getElementById("triple").removeEventListener('click', eventRun);
    document.getElementById("four").removeEventListener('click', eventRun);
    document.getElementById("six").removeEventListener('click', eventRun);
    document.getElementById("undo").removeEventListener('click', undoPreviousBall);

    document.getElementById("bye1").removeEventListener('click',updateByes);
    document.getElementById("bye2").removeEventListener('click',updateByes);
    document.getElementById("bye3").removeEventListener('click',updateByes);
    document.getElementById("bye4").removeEventListener('click',updateByes);
    document.getElementById("bye5").removeEventListener('click',updateByes);
    document.getElementById("bye6").removeEventListener('click',updateByes);

    document.getElementById("lby1").removeEventListener('click',updateLegByes);
    document.getElementById("lby2").removeEventListener('click',updateLegByes);
    document.getElementById("lby3").removeEventListener('click',updateLegByes);
    document.getElementById("lby4").removeEventListener('click',updateLegByes);
    document.getElementById("lby5").removeEventListener('click',updateLegByes);
    document.getElementById("lby6").removeEventListener('click',updateLegByes);

    document.getElementById('changeStriker').removeEventListener('click',getStrikersInXI);
    document.getElementById('changeNonStriker').removeEventListener('click',getNonStrikersInXI);
    document.getElementById('changeBowler').removeEventListener('click',getBowlersInXI);
    document.getElementById('updateStriker').removeEventListener('click',setStriker);
    document.getElementById('updateNonStriker').removeEventListener('click',setNonStriker);
    document.getElementById('updateBowler').removeEventListener('click',setBowler);

    document.getElementById('noBallRunsBtn').removeEventListener('click',updateNoBallRuns);
    document.getElementById('outOnNB').removeEventListener('click',updateNBAndShowBatsmenOnCrease);
    document.getElementById('noWicketOnNB').removeEventListener('click',updateStatusOfWicketOnNB);
    document.getElementById('noBallNextBtn1').removeEventListener('click',getOutBatsmanAndBallingTeamXI);
    document.getElementById('noBallNextBtn2').removeEventListener('click',getWhoDidRunOut);

    document.getElementById('outOnWD').removeEventListener('click',updateStatusOfWicketOnWD);
    document.getElementById('noWicketOnWD').removeEventListener('click',updateStatusOfWicketOnWD);
    document.getElementById('wideBallRunsBtn').removeEventListener('click',updateWideBallRuns);
    document.getElementById('stumpedOnWD').removeEventListener('click',updateWicketOnWD);
    document.getElementById('hitWicketOnWD').removeEventListener('click',updateWicketOnWD);
    document.getElementById('runOutOnWD').removeEventListener('click',updateBatsmenOnCrease);
    document.getElementById('wideBallNextBtn1').removeEventListener('click',getOutBatsmanAndBallingTeamXIWD);
    document.getElementById('wideBallNextBtn2').removeEventListener('click',getWhoDidRunOut);



    document.getElementById('bowled').removeEventListener('click',updateBowledWicket);
    document.getElementById('lbw').removeEventListener('click',updateLbwWicket);
    document.getElementById('hitWicket').removeEventListener('click',updateHitWicket);
    document.getElementById('stumped').removeEventListener('click',updateStumpedWicket);
    document.getElementById('caught').removeEventListener('click',showBallingTeamXI);
    document.getElementById('caughtBy').removeEventListener('click',updateCaughtByAndWicket);
    document.getElementById('runOut').removeEventListener('click',showBatsmenOnCrease);
    document.getElementById('runOutNextBtn1').removeEventListener('click',getOutBatsman);
    document.getElementById('runOutNextBtn2').removeEventListener('click',getRunScoredAndShowBallingTeamXI);
    document.getElementById('runOutNextBtn3').removeEventListener('click',updateRunOutWicket);
}



// var byes = document.getElementById("selectByesModal").addEventListener('click', updateScore);

const totalRunsElem=document.getElementById('totalRuns');
const totalWicketsDownElem=document.getElementById('wicketsDown');

const ballNoElem=document.getElementById('ballNo');
const overNoElem=document.getElementById('overNo');
const totalOversElem=document.getElementById('totalOvers');

const battingTeamNameElem=document.getElementById('battingTeamName');

const strikerNameElem=document.getElementById('strikerName');
const nonStrikerNameElem=document.getElementById('nonStrikerName');
const bowlerNameElem=document.getElementById('bowlerName');

const runsScoredByStrikerElem=document.getElementById('runsScoredByStriker');
const ballsFacedByStrikerElem=document.getElementById('ballsFacedByStriker');

const runsScoredByNonStrikerElem=document.getElementById('runsScoredByNonStriker');
const ballsFacedByNonStrikerElem=document.getElementById('ballsFacedByNonStriker');

const noOfRunsConceededByBowlerElem=document.getElementById('noOfRunsConceededByBowler');
const noOfOversPlayerByBowlerElem=document.getElementById('noOfOversPlayedByBowler');
const noOfWicketsTakenByBowlerElem=document.getElementById('noOfWicketsTakenByBowler');

const currentOverDetailsElem=document.getElementById('currentOverDetails');

const strikerBattersInXIElem=document.getElementById('strikerBattersInXI');
const strikerBallersInXIElem=document.getElementById('strikerBallersInXI');
const strikerAllroundersInXIElem=document.getElementById('strikerAllroundersInXI');
const nonStrikerBattersInXIElem=document.getElementById('nonStrikerBattersInXI');
const nonStrikerBallersInXIElem=document.getElementById('nonStrikerBallersInXI');
const nonStrikerAllroundersInXIElem=document.getElementById('nonStrikerAllroundersInXI');
const battersInXIElem=document.getElementById('battersInXI');
const ballersInXIElem=document.getElementById('ballersInXI');
const allroundersInXIElem=document.getElementById('allroundersInXI');

const changeBowlerModalElem = document.getElementById('changeBowler');
const changeStrikerModalElem=document.getElementById('changeStriker');
const changeNonStrikerModalElem=document.getElementById('changeNonStriker');
const currentBatsmenOnCreaseElem=document.getElementById('currentBatsmenOnCrease');
const batsmenOnCreaseElem=document.getElementById('batsmenOnCrease');
const currentBatsmenOnCreaseWDElem=document.getElementById('currentBatsmenOnCreaseWD');
$(".card-body").click(function(e){
	e.target.classList.toggle("activecard");

})


var currentMatchOver = 0;
var currentOverBowl = 0;
var currentMatchBowl = currentMatchOver + '.' + currentOverBowl;
var currentRuns = 0;
var currentWicketsFallen = 0;
var totalNumbeOfovers = 5;

let alreadyClicked=true; // Changed to true by Dipesh

let runsByBat=0;
let runType="";
let wasExtraRun=false;

let strikerName="";
let nonStrikerName="";
let bowlerName="";

let strikerID=0;
let nonStrikerID=0;
let bowlerID=0;

let outBatsmanID=0;
let outByID="";

let wasWicketOnNB=false;

let wasWicketOnWD=false;
let wicketTypeOnWD="";

let runsScoredBeforeRunOut=0;

//to stop firsttime click on bowlers modal
let counter=0;

function updateByes(e){
    // // e.preventDefault();
    // console.log(e.target);
    // var byeRuns= parseInt(e.target.id.substr(3,4));
    // // currentRuns = parseInt(byeRuns) + parseInt(currentRuns);
    // // console.log(currentRuns);
    // updateScore(parseInt(byeRuns));
    // byeRuns = 0;
    // console.log(byeRuns);
    wasExtraRun=true;
    totalByeRuns=e.target.dataset.value;
    ballType="bye";
    updateExtras(totalByeRuns,ballType);
}

function updateLegByes(e){
    wasExtraRun=true;
    totalLegByeRuns=e.target.dataset.value;
    ballType="leg_bye";
    updateExtras(totalLegByeRuns,ballType);
}


function updateStatusOfWicketOnWD(e){
    wasWicketOnWD=e.target.dataset.value;
}

function updateWicketOnWD(e){
    wicketTypeOnWD=e.target.dataset.value;
    totalWideBallRuns=1;
    ballType="wide";
    updateExtrasAndWicket(wicketTypeOnWD,strikerID,bowlerID,totalWideBallRuns,ballType);
}

function updateWideBallRuns(e){
    wasExtraRun=true;
    totalWideBallRuns=document.getElementById('wideBallRuns').value;
    totalWideBallRuns=parseInt(totalWideBallRuns)+1;
    ballType="wide";
    //remaining 2 types covered separtely
    wicketType="run_out";
    console.log(totalWideBallRuns);
    if(wasWicketOnNB){
        updateExtrasAndWicket(wicketType,outBatsmanID,outByID,totalWideBallRuns,ballType);
    }else{
        updateExtras(totalWideBallRuns,ballType);
    }
}

function getOutBatsmanAndBallingTeamXIWD(e){
    //to decide who was out
    if(currentBatsmenOnCreaseWDElem.children[0].childNodes[1].checked){
        outBatsmanID=strikerID;
    }else{
        outBatsmanID=nonStrikerID;
    }

    const currentBallingTeamElemWD=document.getElementById('currentBallingTeamWD');
    getBallingTeamXI(currentBallingTeamElemWD,"fieldingXIRadio");
}

function updateStatusOfWicketOnNB(){
    wasWicketOnNB=false;
}

function updateNoBallRuns(e){
    wasExtraRun=true;
    totalNoBallRuns=document.getElementById('noBallRuns').value;
    ballType="no_ball";
    let wicketType="run_out";
    console.log(totalNoBallRuns);
    if(wasWicketOnNB){
        updateExtrasAndWicket(wicketType,outBatsmanID,outByID,totalNoBallRuns,ballType);
    }else{
        updateExtras(totalNoBallRuns,ballType);
    }
}

function updateExtrasAndWicket(wicketType,outBatsmanID,outByID,extraRuns,ballType){
    const data={
        wicket_type:wicketType,
        dismissed_batsman:outBatsmanID,
        out_by:outByID,
        extra_runs:extraRuns,
        ball_type:ballType
    }
    const requestHeaders={
        'Content-Type':'application/json'
    };

    console.log(data);
    let currentURL=`http://localhost:8000/api/tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/match_scorecards/${matchScoredCardID}/match_detail_scorecards`;

    http.post(currentURL,data,requestHeaders)
        .then(function(data){
            console.log(data);
            updateScreen(data.data);
            if(outBatsmanID==strikerID){
                changeStrikerModalElem.click();
            }else{
                changeNonStrikerModalElem.click();
            }
        })
        .catch(function(err){
            console.warn(err);
        })
}

function updateExtras(extraRuns,ballType){
    const data={
        extra_runs:extraRuns,
        ball_type:ballType
    }
    const requestHeaders={
        'Content-Type':'application/json'
    };

    console.log(data);
    let currentURL=`http://localhost:8000/api/tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/match_scorecards/${matchScoredCardID}/match_detail_scorecards`;

    http.post(currentURL,data,requestHeaders)
        .then(function(data){
            console.log(data);
            updateScreen(data.data);
        })
        .catch(function(err){
            console.warn(err);
        })
}

function updateNBAndShowBatsmenOnCrease(){
    wasWicketOnNB=true;
    getBatsmenOnCrease(currentBatsmenOnCreaseElem);
}

function getOutBatsman(){
    if(batsmenOnCreaseElem.children[0].childNodes[1].checked){
        outBatsmanID=strikerID;
    }else{
        outBatsmanID=nonStrikerID;
    }
}

function getRunScoredAndShowBallingTeamXI(){
    runsScoredBeforeRunOut=document.getElementById('totalRunsScoredBeforeRunOut').value;
    const fieldingXIElem2=document.getElementById('fieldingXI2');
    getBallingTeamXI(fieldingXIElem2,"fieldingXIRadio");
}

function getOutBatsmanAndBallingTeamXI(e){
    //to decide who was out
    if(currentBatsmenOnCreaseElem.children[0].childNodes[1].checked){
        outBatsmanID=strikerID;
    }else{
        outBatsmanID=nonStrikerID;
    }

    const currentBallingTeamElem=document.getElementById('currentBallingTeam');
    getBallingTeamXI(currentBallingTeamElem,"fieldingXIRadio");
}

function showBallingTeamXI(){
    const fieldingXIElem=document.getElementById('fieldingXI');
    getBallingTeamXI(fieldingXIElem,"fieldingXIRadio");
}

function getBallingTeamXI(elem,radioName)
{
    let currentURL=BASEURL+`tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/bowling-team-players`;

    http.get(currentURL)
        .then(function(data){
            let batters="";
            let ballers="";
            let allrounders="";
            [batters,ballers,allrounders]=renderDataWithRadio(data,radioName);
            elem.children[0].innerHTML=batters;
            elem.children[1].innerHTML=ballers;
            elem.children[2].innerHTML=allrounders;
        })
        .catch(function(err){
            console.warn(err);
        })
}

function getWhoDidRunOut(e){
    outByID="";
    let radioBtns = document.getElementsByName('fieldingXIRadio');
    for (let i=0, n=radioBtns.length;i<n;i++)
    {
        if (radioBtns[i].checked)
        {
            outByID = radioBtns[i].value;
        }
    }
    return outByID;
}

function updateRunOutWicket(){
    let wicketType="run_out";
    outByID=getWhoDidRunOut();
    runTypes=["dot","single","double","triple","four","","six"]
    runType=runTypes[runsScoredBeforeRunOut];
    console.log(outByID);
    console.log(outBatsmanID);
    console.log(runsScoredBeforeRunOut);
    console.log(runType);
    updateRunsAndWicket(wicketType,outBatsmanID,outByID,runsScoredBeforeRunOut,runType);
}

function updateRunsAndWicket(wicketType,outBatsmanID,outByID,runsByBat,runType){
    const data={
        wicket_type:wicketType,
        dismissed_batsman:outBatsmanID,
        out_by:outByID,
        runs_by_bat:runsByBat,
        run_type:runType
    }
    const requestHeaders={
        'Content-Type':'application/json'
    };

    console.log(data);
    let currentURL=`http://localhost:8000/api/tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/match_scorecards/${matchScoredCardID}/match_detail_scorecards`;

    http.post(currentURL,data,requestHeaders)
        .then(function(data){
            console.log(data);
            updateScreen(data.data);
            if(outBatsmanID==strikerID){
                changeStrikerModalElem.click();
            }else{
                changeNonStrikerModalElem.click();
            }
        })
        .catch(function(err){
            console.warn(err);
        })
}

function updateBowledWicket(e){
    let wicketType="bowled";
    outBatsmanID=strikerID;
    let outBy=bowlerID;
    updateWicket(wicketType,outBatsmanID,outBy);
}

function updateLbwWicket(e){
    let wicketType="lbw";
    outBatsmanID=strikerID;
    let outBy=bowlerID;
    updateWicket(wicketType,outBatsmanID,outBy);
}

function updateHitWicket(e){
    let wicketType="hit_wicket";
    outBatsmanID=strikerID;
    let outBy=bowlerID;
    updateWicket(wicketType,outBatsmanID,outBy);
}

function updateStumpedWicket(e){
    let wicketType="stumping";
    outBatsmanID=strikerID;
    let outBy=bowlerID;
    updateWicket(wicketType,outBatsmanID,outBy);
}

function updateCaughtByAndWicket(){
    let wicketType="catch_out";
    outBatsmanID=strikerID;

    let caughtByID="";
    let radioBtns = document.getElementsByName('fieldingXIRadio');
    for (let i=0, n=radioBtns.length;i<n;i++)
    {
        if (radioBtns[i].checked)
        {
            caughtByID = radioBtns[i].value;
        }
    }
    console.log(caughtByID);
    updateWicket(wicketType,outBatsmanID,caughtByID);
}

function updateWicket(wicketType,dismissedBatsman,outBy){
    const data={
        wicket_type:wicketType,
        dismissed_batsman:dismissedBatsman,
        out_by:outBy
    }
    const requestHeaders={
        'Content-Type':'application/json'
    };

    console.log(data);
    let currentURL=`http://localhost:8000/api/tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/match_scorecards/${matchScoredCardID}/match_detail_scorecards`;

    http.post(currentURL,data,requestHeaders)
        .then(function(data){
            console.log(data);
            updateScreen(data.data);
            if(outBatsmanID==strikerID){
                changeStrikerModalElem.click();
            }else{
                changeNonStrikerModalElem.click();
            }
        })
        .catch(function(err){
            console.warn(err);
        })
}

function showBatsmenOnCrease(){
    getBatsmenOnCrease(batsmenOnCreaseElem);
}

function updateBatsmenOnCrease(){
    getBatsmenOnCrease(currentBatsmenOnCreaseWDElem);
}

function getBatsmenOnCrease(elem){
    elem.innerHTML=`
        <div>
            <input class="form-check-input" type="radio" name="exampleRadios" id="${strikerID}" value="${strikerID}">
            <label class="form-check-label" for="${strikerID}">
            ${strikerName}
            </label>
        </div>
        <div>
            <input class="form-check-input" type="radio" name="exampleRadios" id="${nonStrikerID}" value="${nonStrikerID}">
            <label class="form-check-label" for="${nonStrikerID}">
            ${nonStrikerName}
            </label>
        </div>
    `
}

function eventRun(e){
    wasExtraRun=false;
    runTypes=["dot","single","double","triple","four","","six"]
    runsByBat=e.target.dataset.value;
    runType=runTypes[runsByBat];

    updateRuns(runsByBat,runType);
}

function updateRuns(runsByBat,runType){
    const data={
        runs_by_bat:runsByBat,
        run_type:runType
    }
    const requestHeaders={
        'Content-Type':'application/json'
    };

    console.log(data);
    let currentURL=`http://localhost:8000/api/tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/match_scorecards/${matchScoredCardID}/match_detail_scorecards`;

    removeEventListenersOnButtons();

    console.log(matchScoredCard.ball_number)
    if(matchScoredCard.ball_number%6 == 0) {
        currentOverDetailsElem.innerHTML = "";
        currentOverDetailsElem.innerHTML = overStatsLoaderHTML;
    } else {
        currentOverDetailsElem.innerHTML += overStatsLoaderHTML;
    }

    http.post(currentURL,data,requestHeaders)
        .then(function(data){
            console.log(data);
            getDataAndUpdateScreen();
            addEventListenersOnButtons();
        })
        .catch(function(err){
            console.warn(err);
        })

}

function getStrikersInXI(evt){
    let currentURL=BASEURL+`tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/batting-team-players?is_out=false`;

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
    let currentURL=BASEURL+`tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/batting-team-players?is_out=false`;

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
    let strikerBatsmanID="";
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

    const data={
        strike_batsman_id:strikerBatsmanID,
    }
    const requestHeaders={
        'Content-Type':'application/json'
    };

    console.log(data);

    let currentURL=`http://localhost:8000/api/tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/match_scorecards/${matchScoredCardID}/change-strike-batsman`;

    http.put(currentURL,data,requestHeaders)
        .then(function(data){
            getDataAndUpdateScreen();
        })
        .catch(function(err){
            console.warn(err);
        })
}

function setNonStriker(){
    let nonStrikerBatsmanID="";
    let radioBtns = document.getElementsByName('team1PlayersRadio');
    for (let i=0, n=radioBtns.length;i<n;i++)
    {
        if (radioBtns[i].checked)
        {

            nonStrikerBatsmanID = radioBtns[i].value;
        }
    }
    console.log(nonStrikerBatsmanID);

    const data={
        non_strike_batsman_id:nonStrikerBatsmanID,
    }
    const requestHeaders={
        'Content-Type':'application/json'
    };

    console.log(data);

    let currentURL=`http://localhost:8000/api/tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/match_scorecards/${matchScoredCardID}/change-non-strike-batsman`;

    http.put(currentURL,data,requestHeaders)
        .then(function(data){
            getDataAndUpdateScreen();
        })
        .catch(function(err){
            console.warn(err);
        })
}

function getBowlersInXI(evt){
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
    let bowlerID="";
    let radioBtns = document.getElementsByName('playersRadio');
    for (let i=0, n=radioBtns.length;i<n;i++)
    {
        if (radioBtns[i].checked)
        {
            bowlerID = radioBtns[i].value;
        }
    }
    console.log(bowlerID);

    const data={
        bowler_id:bowlerID,
    }
    const requestHeaders={
        'Content-Type':'application/json'
    };

    console.log(data);

    let currentURL=`http://localhost:8000/api/tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/match_scorecards/${matchScoredCardID}/change-bowler`;

    http.put(currentURL,data,requestHeaders)
        .then(function(data){
            getDataAndUpdateScreen();
        })
        .catch(function(err){
            console.warn(err);
        })
}

function getDataAndUpdateScreen(){
    currentURL = `http://localhost:8000/api/tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/match_scorecards?inning=${inning}`;
            http.get(currentURL)
                .then(function(data){
                    console.log(data);
                    matchScoredCard = data.data;
                    updateScreen(data.data)
                })
                .catch(function(err){
                    console.log(err)
                })
}

function updateScreen(data){
    let battingTeamName=data.batting_team.name;
    let totalWicketsDown=data.wickets_taken;
    let totalRunsScored=data.total_runs_scored;
    let overNo=(data.over-1 === -1) ? 0 : data.over-1;
    let totalOvers=data.tournament_match.no_of_overs;

    strikerName=data.strike_batsman.player.user.first_name+"*";
    nonStrikerName=data.non_strike_batsman.player.user.first_name
    bowlerName=data.bowler.player.user.first_name;

    strikerID=data.strike_batsman.player.user.id;
    nonStrikerID=data.non_strike_batsman.player.user.id;
    bowlerID=data.bowler.player.user.id;


    let runsScoredByStriker=data.strike_batsman.no_of_singles+data.strike_batsman.no_of_doubles*2+data.strike_batsman.no_of_triples*3+data.strike_batsman.no_of_fours*4+data.strike_batsman.no_of_fives*5+data.strike_batsman.no_of_sixes*6;
    let runsScoredByNonStriker=data.non_strike_batsman.no_of_singles+data.non_strike_batsman.no_of_doubles*2+data.non_strike_batsman.no_of_triples*3+data.non_strike_batsman.no_of_fours*4+data.non_strike_batsman.no_of_fives*5+data.non_strike_batsman.no_of_sixes*6;

    let noOfRunsConceededByBowler=data.bowler.runs_conceeded;
    let noOfOversPlayerByBowler=data.bowler.no_of_overs_played;
    let noOfWicketsTakenByBowler=data.bowler.no_of_wickets_taken;

    let ballsFacedByStriker=data.strike_batsman.no_of_balls_faced;
    let ballsFacedByNonStriker=data.non_strike_batsman.no_of_balls_faced;

    let ballNo=data.ball_number;

    let currentBall=ballNo%6;

    if(ballNo%6===1)
        alreadyClicked=false;

    updateBowlingTimeLine(ballNo);

    totalRunsElem.innerHTML=totalRunsScored;
    totalWicketsDownElem.innerHTML=totalWicketsDown;
    battingTeamNameElem.innerHTML=battingTeamName;
    ballNoElem.innerHTML=currentBall;
    overNoElem.innerHTML=overNo;
    totalOversElem.innerHTML=totalOvers;
    strikerNameElem.innerHTML=strikerName;
    nonStrikerNameElem.innerHTML=nonStrikerName;
    bowlerNameElem.innerHTML=bowlerName;
    runsScoredByStrikerElem.innerHTML=runsScoredByStriker;
    runsScoredByNonStrikerElem.innerHTML=runsScoredByNonStriker;
    ballsFacedByStrikerElem.innerHTML=ballsFacedByStriker;
    ballsFacedByNonStrikerElem.innerHTML=ballsFacedByNonStriker;
    noOfOversPlayerByBowlerElem.innerHTML=noOfOversPlayerByBowler;
    noOfRunsConceededByBowlerElem.innerHTML=noOfRunsConceededByBowler;
    noOfWicketsTakenByBowlerElem.innerHTML=noOfWicketsTakenByBowler;

    if(ballNo%6==0){
        counter++;
        if(!alreadyClicked){
            if(!counter==0){
                changeBowlerModalElem.click();
            }
            alreadyClicked=true;
        }
        overNo=overNo+1;
        overNoElem.innerHTML=overNo;
    }
}

function updateBowlingTimeLine(ballNo){
    let currentURL=BASEURL+`tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/match_scorecards/${matchScoredCardID}/current-over-details`;
    // LOADER HTML
    // <span id="over-stats-loader" class="ms-3 mb-5"></span>

    http.get(currentURL)
        .then(function(data){
            console.log(data);
            currentOverDetailsElem.innerHTML="";
            data.data.forEach(function(ball){
                if(ball.is_legal_delivery && !ball.out_by){
                    currentOverDetailsElem.innerHTML+=`<div class="col-md-1 circle">${ball.runs_by_bat}</div>`;
                }else if(ball.is_legal_delivery && ball.out_by){
                    if(ball.runs_by_bat!=0){
                        currentOverDetailsElem.innerHTML+=`<div class="col-md-1 circle">W+${ball.runs_by_bat}</div>`;
                    }else{
                        currentOverDetailsElem.innerHTML+=`<div class="col-md-1 circle">W</div>`;
                    }
                }else{
                    if(ball.was_leg_bye){
                        currentOverDetailsElem.innerHTML+=`<div class="col-md-1 circle">LB${ball.extra_runs}</div>`;
                    }else if(ball.was_bye){
                        currentOverDetailsElem.innerHTML+=`<div class="col-md-1 circle">B${ball.extra_runs}</div>`;
                    }else if(ball.was_no_ball){
                        if(ball.out_by){
                            currentOverDetailsElem.innerHTML+=`<div class="col-md-1 circle">NB+W</div>`;
                        }else{
                            currentOverDetailsElem.innerHTML+=`<div class="col-md-1 circle">NB+${ball.extra_runs}</div>`;
                        }
                    }else if(ball.was_wide){
                        if(ball.out_by){
                            currentOverDetailsElem.innerHTML+=`<div class="col-md-1 circle">WD+W</div>`;
                        }else{
                            if(ball.extra_runs>0){
                                currentOverDetailsElem.innerHTML+=`<div class="col-md-1 circle">WD+${ball.extra_runs-1}</div>`;
                            }else{
                                currentOverDetailsElem.innerHTML+=`<div class="col-md-1 circle">WD</div>`;
                            }
                        }
                    }
                }
            });

        })
        .catch(function(err){
            console.warn(err);
        })
}

function undoPreviousBall(){
    let matchDetailScoreCardID=-1;

    let currentURL=BASEURL+`tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/match_scorecards/${matchScoredCardID}/match_detail_scorecards/last-ball-details`;

    const requestHeaders={
        'Content-Type':'application/json'
    };
    http.get(currentURL)
        .then(function(data){
            matchDetailScoreCardID=data.data.id;
            // console.log(matchDetailScoreCardID);
            let currentURL=BASEURL+`tournaments/${tournamentID}/tournament_matches/${tournamentMatchID}/match_scorecards/${matchScoredCardID}/match_detail_scorecards/${matchDetailScoreCardID}/undo-last-ball`;

            http.delete(currentURL,requestHeaders)
                .then(function(data){
                    getDataAndUpdateScreen();
                })
                .catch(function(err){
                    console.warn(err);
                })
        })
        .catch(function(err){
            console.warn(err);
        })
}

// function updateScore(score){
// // console.log('hey');
//     let currentBowl = score;
//     // console.log(currentBowl);

//     if(isFairDelivery(currentBowl))
//     {
//         if(isWicket(currentBowl)){
//             currentWicketsFallen = parseInt(currentWicketsFallen) + 1;

//         }

//         if(Number.isInteger(parseInt(currentBowl))){
//             currentRuns = parseInt(score) + parseInt(currentRuns);
//         }

//         if(currentOverBowl == 5){

//             currentMatchOver = currentMatchOver + 1;
// 			currentOverBowl = 0;
//         }

//         // if(currentBowl == 'undo'){

//         // }
//         if(currentBowl == 'bye'){
//             return;
//         }

//         if(currentBowl == 'lb'){
//             return;
//         }
//         else {
//             currentOverBowl = currentOverBowl + 1;
//             // var bowlsix = 6;
//         }

//     }
//     else
//     {
//         currentRuns = 1 + parseInt(currentRuns);
//     }
//     // console.log(currentRuns);
//     var currentMatchBowl = currentMatchOver + '.' + currentOverBowl
//     var liveScore = currentRuns + '/' + currentWicketsFallen + '(' + currentMatchBowl + '/' + totalNumbeOfovers + ')';
//     console.log(currentRuns)
//     let scoreholder = document.getElementById('score');
//     scoreholder.innerHTML = `<h4>${currentRuns + '/' + currentWicketsFallen}</h4>
//                             <h6 class="ms-2 mt-2">
//                             ${'(' + currentMatchBowl + '/' + totalNumbeOfovers + ')'}
//                             </h6>`;
//     let bowl1 = document.getElementById('bowl1');
//     let bowl2 = document.getElementById('bowl2');
//     let bowl3 = document.getElementById('bowl3');
//     let bowl4 = document.getElementById('bowl4');
//     let bowl5 = document.getElementById('bowl5');
//     let bowl6 = document.getElementById('bowl6');
//     let bowltwo = document.getElementById('bowltwo');

//     // console.log(currentMatchBowl);
//     // console.log(currentOverBowl);

//     if(currentOverBowl == 1){
//         bowl1.innerHTML = `<h6>${currentBowl}</h6>`;
//         bowl2.innerHTML = `<h6>0</h6>`;
//         bowl3.innerHTML = `<h6>0</h6>`;
//         bowl4.innerHTML = `<h6>0</h6>`;
//         bowl5.innerHTML = `<h6>0</h6>`;
//         bowl6.innerHTML = `<h6>0</h6>`;

//     }

//     if(currentOverBowl == 2){
//         bowl2.innerHTML = `<h6 id="bowltwo">${currentBowl}</h6>`;
//         // console.log(currentBowlwithoutno);


//         if(currentBowl =='nb'){
//             // bowl2.innerHTML=`<h6>${currentBowlwithoutno}Nb</h6>`;
//             bowl2.innerHTML = `<h6 >${bowltwo}</h6>`;
//         }
//     }

//     if(currentOverBowl == 3){
//         bowl3.innerHTML = `<h6>${currentBowl}</h6>`;
//     }

//     if(currentOverBowl == 4){
//         bowl4.innerHTML = `<h6>${currentBowl}</h6>`;
//     }

//     if(currentOverBowl == 5){
//         bowl5.innerHTML = `<h6>${currentBowl}</h6>`;
//         // var bowlsix = 6;
//     }
//     if(currentBowl == 'nb'){
//         // console.log('hey');
//         // console.log(currentOverBowl);
//         // bowl{currentBowl}

//     }
//     // console.log(currentOverBowl);


//     const arr = ['1.0', '2.0', '3.0', '4.0', '5.0'];
//     // const arr2 = [1.0, 2.0, 3.0, 4.0, 5.0];
//     // console.log(arr);
//     // console.log(currentMatchBowl);
//     if(arr.includes(currentMatchBowl)){
//         bowl6.innerHTML = `<h6>${currentBowl}</h6>`;
//     }

//     function isWicket(currentBowl){
//         if(currentBowl == 'w'){
//             return true;
//         }
//         return false;
//     }

//     function isFairDelivery(currentBowl){
//         // console.log(currentBowl);
//         if(currentBowl == 'wide' || currentBowl == 'nb'){
//             return false;
//         }
//         return true;
//     }
// }




//Helper
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
