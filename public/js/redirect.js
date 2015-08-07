var Timer;
var TotalSeconds;
                                
function CreateTimer(TimerID, Time) { //run this second
    Timer = document.getElementById(TimerID);
    TotalSeconds = Time;
    
    UpdateTimer(); //shows the current time at this moment before calling the tick function
    window.setTimeout("Tick()", 1000);
}

function Tick() { //this function keeps calling itself
    TotalSeconds--;

    if(TotalSeconds > 0){
        UpdateTimer();                                                                                                  
        window.setTimeout("Tick()", 1000);
    }
    else {
        window.location.href = "../../index.php";
    }
}

function UpdateTimer() {
    Timer.innerHTML = TotalSeconds;
}

CreateTimer("timer", 3); //run this first
