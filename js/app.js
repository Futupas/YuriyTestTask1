'use strict';

/**
 * @type {Array.<Object>}
 */
let globalTasks = [];
let sorting = 'creationIncrease';

window.onload = (e) => {
    globalTasks = [];
    sorting = 'creationIncrease';

    setTodayDateToInput();
    applyEmailMask();    
    getTasks();


    document.getElementById('addTaskForm').onsubmit = async (e) => {
        e.preventDefault();
    
        let response = await fetch('/add_task.php', {
            method: 'POST',
            body: new FormData(document.getElementById('addTaskForm'))
        });
    
        let result = await response.json();
    
        if (result.ok === true && typeof(result.added_task) === 'object') {
            globalTasks.push(result.added_task);
            sortTasks();
            searchTasks();
            document.querySelector('#addTaskForm input[name="name"]').value = '';
            document.querySelector('#addTaskForm input[name="email"]').value = '';
            document.querySelector('#addTaskForm input[name="endingDate"]').value = '';
            document.querySelector('#addTaskForm input[name="taskName"]').value = '';
            document.querySelector('#addTaskForm textarea[name="taskDescription"]').value = '';
        } else {
            alert ('Ошибка добавления задачи');
        }
    };

    document.getElementById('sortingSelect').oninput = (e) => {
        sortTasks();
    }
    document.getElementById('searchInput').oninput = (e) => {
        searchTasks();
    }
}

function sortTasks() {
    let sortingValue = document.getElementById('sortingSelect').value;
    sorting = sortingValue;
    if (sorting === 'creationIncrease') {
        globalTasks.sort((a, b) => { return a.adding_unix_date - b.adding_unix_date; });
        fillTasksTable();
    } else if (sorting === 'creationDecrease') {
        globalTasks.sort((a, b) => { return b.adding_unix_date - a.adding_unix_date; });
        fillTasksTable();
    } else if (sorting === 'doneIncrease') {
        globalTasks.sort((a, b) => { return a.ending_unix_date - b.ending_unix_date; });
        fillTasksTable();
    } else if (sorting === 'doneDecrease') {
        globalTasks.sort((a, b) => { return b.ending_unix_date - a.ending_unix_date; });
        fillTasksTable();
    } 
}
function searchTasks() {
    let searchText = document.getElementById('searchInput').value;
    if (searchText === '') {
        fillTasksTable();
        return true;
    }
    let searchingType = document.getElementById('searchingSelect').value;
    if (searchingType === 'name') {
        fillTasksTable(globalTasks.filter((e) => {
            return e.name.toLowerCase().includes(searchText.toLowerCase());
        }));
    }
    else if (searchingType === 'taskName') {
        fillTasksTable(globalTasks.filter((e) => {
            return e.task_name.toLowerCase().includes(searchText.toLowerCase());
        }));
    }
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

async function getTasks() {
    let response = await fetch('/get_tasks.php');
    let result = await response.json();
    globalTasks = result.tasks;
    globalTasks.sort((a, b) => { return a.adding_unix_date - b.adding_unix_date; });
    fillTasksTable();
}

function fillTasksTable(tasks) {
    let givenTasks = tasks === undefined ? globalTasks : tasks;
    let tbody = document.querySelector('#mainTable > tbody')
    tbody.innerHTML = '';
    givenTasks.forEach(task => {
        let tr = document.createElement('tr');
        tr.task = task;
        task.tr = tr;
        let nameTd = document.createElement('td');
        nameTd.innerText = task.name;
        tr.appendChild(nameTd);
        let taskNameTd = document.createElement('td');
        taskNameTd.innerText = task.task_name;
        tr.appendChild(taskNameTd);
        let addingDateTd = document.createElement('td');
        addingDateTd.innerText = new Date(task.adding_unix_date * 1000).toLocaleDateString("uk-UA");
        tr.appendChild(addingDateTd);
        let endingNameTd = document.createElement('td');
        endingNameTd.innerText = new Date(task.ending_unix_date * 1000).toLocaleDateString("uk-UA");
        tr.appendChild(endingNameTd);
        let descriptionTd = document.createElement('td');
        descriptionTd.innerText = task.task_description;
        tr.appendChild(descriptionTd);
        let deleteTd = document.createElement('td');
        let deleteBtn = document.createElement('button');
        deleteBtn.innerText = 'Удалить';
        deleteBtn.classList.add('btn', 'btn-danger');
        deleteBtn.onclick = async (e) => {
            let taskName = e.target.parentElement.parentElement.task.task_name;
            if (!confirm(`Вы действительно хотите удалить задачу "${taskName}"?`)) return true;
            let taskId = e.target.parentElement.parentElement.task.id;
            let formData = new FormData();
            formData.append('id', taskId);

            // console.log(e.target.parentElement.parentElement.task);
            let response = await fetch('/delete_task.php', {
                method: 'POST',
                body: formData
            });
        
            let result = await response.json();
        
            if (result.ok === true) {
                globalTasks = globalTasks.filter(e => e.id !== taskId);
                e.target.parentElement.parentElement.remove();
            } else {
                (async () => {
                    await getTasks();
                    sortTasks();
                    searchTasks();
                })();
                alert ('Ошибка удаления задачи');
            }
        }
        deleteTd.appendChild(deleteBtn);
        tr.appendChild(deleteTd);
        tbody.appendChild(tr);
    });
}


