'use strict';


window.onload = (e) => {
    setTodayDateToInput();
    // applyEmailMask();    


    document.getElementById('addTaskForm').onsubmit = async (e) => {
        e.preventDefault();
    
        let response = await fetch('/server.php', {
            method: 'POST',
            body: new FormData(document.getElementById('addTaskForm'))
        });
    
        let result = await response.text();
    
        alert(result);
    };
}

function setTodayDateToInput() {
    let today = new Date();
    let dd = today.getDate() + '';
    if (dd < 10) dd = '0' + dd;

    let mm = today.getMonth()+1 + '';
    if (mm < 10) mm = '0' + mm;

    let yyyy = today.getFullYear();
    
    let fullDate = `${dd}.${mm}.${yyyy}`;

    document.querySelector('#addTaskForm input[name=endingDate]').placeholder = fullDate;

    let instance = new dtsel.DTS('#addTaskForm input[name=endingDate]',  {
        showTime: false,
        showDate: true,
        dateFormat: "dd.mm.yyyy",
        direction: 'BOTTOM'
    });
}

function applyEmailMask() {
    /**
     * @type HTMLElement
     */
    let emailInput = document.querySelector('#addTaskForm input[name=email]');
    emailInput.onclick = (e) => {
        if (emailInput.maskPosition === undefined && emailInput.realValue === undefined) {
            emailInput.value = '@_._';
            emailInput.selectionStart = 0;
            emailInput.selectionEnd = 0;
        }
        
        // return false;
    }
    emailInput.onkeydown = (e) => {
        // ___0___@___1___.___2___
        if (emailInput.maskPosition === undefined) emailInput.maskPosition = 0;
        if (emailInput.realValue === undefined) emailInput.realValue = '';
        let key = e.key;
        if (key === 'Backspace') {
            console.log(emailInput.selectionStart);
            console.log(emailInput.selectionEnd);
        } else if (key === 'Delete') {

        }
        if (emailInput.maskPosition === 0) {
            emailInput.realValue += key;
            if (key === '@') {
                emailInput.value = emailInput.realValue + '_._';
                emailInput.selectionStart = emailInput.realValue.length;
                emailInput.selectionEnd = emailInput.realValue.length;
                emailInput.maskPosition = 1;
            } else {
                emailInput.value = emailInput.realValue + '@_._';
                emailInput.selectionStart = emailInput.realValue.length;
                emailInput.selectionEnd = emailInput.realValue.length;
            }
        } else if (emailInput.maskPosition === 1) {
            //
        } else if (emailInput.maskPosition === 2) {
            //
        } else {

        }
        
        return false;
    }
}
