<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task manager</title>
    <link rel="stylesheet" href="lib/bootstrap-3.4.1-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="lib/dtsel/dtsel.css" />
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
    <div class="addTask col-md-4">
        <form id="addTaskForm" class="form-group">
            <table>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <h3>Добавить задачу</h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        ФИО:
                    </td>
                    <td>
                        <input required type="text" name="name" value="" placeholder="Роман Паркур" class="form-control" />
                    </td>
                </tr>
                <tr>
                    <td>
                        E-Mail:
                    </td>
                    <td>
                        <input required type="text" name="email" value="" placeholder="roman@park.ur" class="form-control" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Дата завершения:
                    </td>
                    <td>
                        <input required type="text" name="endingDate" class="form-control" autocomplete="no" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Название задачи
                    </td>
                    <td>
                        <input required type="text" name="taskName" class="form-control" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Описание задачи
                    </td>
                    <td>
                        <textarea name="taskDescription" required cols="30" rows="6" maxlength="1000" class="form-control" style="resize: vertical;"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <input type="submit" class="btn btn-default" value="Добавить" />
                    </td>
                </tr>
            </table>
            
            
            
        </form>
    </div>
    <div class="tasksTable col-md-8">
        <div style="margin-bottom: 10px;">
            Сортировка по
            <select name="" id="sortingSelect" class="form-control" style="display: inline-block; width: auto;">
                <option value="creationIncrease" selected>дате добавления, по возрастанию</option>
                <option value="creationDecrease">дате добавления, по убыванию</option>
                <option value="doneIncrease">дате окончания, по возрастанию</option>
                <option value="doneDecrease">дате окончания, по убываниею</option>
            </select>
            <br />
            Поиск по
            <select name="" id="searchingSelect" class="form-control" style="display: inline-block; width: auto;">
                <option value="name" selected>ФИО</option>
                <option value="taskName">названию задачи</option>
            </select>
            :
            <input type="text" size="20" id="searchInput" class="form-control" style="display: inline-block; width: auto;" />
        </div>
        <table id="mainTable" class="table table-striped table-hover">
            <thead style="font-weight: bold;">
                <tr>
                    <td>ФИО</td>
                    <td>Название задачи</td>
                    <td>Дата добавления</td>
                    <td>Дата завершения</td>
                    <td>Описание</td>
                    <td></td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <script src="lib/dtsel/dtsel.js"></script>
    <script src="./lib/Inputmask-5.x/dist/inputmask.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
