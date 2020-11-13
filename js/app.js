'use strict';


window.onload = (e) => {
    setTodayDateToInput();
    applyEmailMask();    


    document.getElementById('addTaskForm').onsubmit = async (e) => {
        e.preventDefault();
    
        let response = await fetch('/add_task.php', {
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
        dateFormat: 'dd.mm.yyyy',
        direction: 'BOTTOM'
    });
}

function applyEmailMask() {
    Inputmask({'mask': '*{3,20}@*{1,20}.*{2,7}', }).mask(document.querySelector('#addTaskForm input[name=email]'));
}



