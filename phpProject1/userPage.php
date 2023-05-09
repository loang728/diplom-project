<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}
?>
<html>
    <head>

        <title>Profile</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <link rel="stylesheet" type="text/css" href="skins/terrace/dhtmlx.css"/>

        <script src="codebase/dhtmlx.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="functions.js"></script>
        <meta charset="UTF-8">


        <style>
            div#sidebarObj {
                position: relative;
                margin-left: 10px;
                margin-top: 10px;
                width: 1300px;
                height: 600px;
            }
        </style>

        <style>
            .even{
                background-color:<?php echo $_SESSION['even'];?> ; //. " " . $_SESSION['userlast'] 
            }
            .uneven{
                background-color:<?php echo $_SESSION['uneven']; ?>; //#F0F8FF;
            }
        </style>

        <style>
            div#layoutObjChartTasks {
                position: relative;
                margin-top: 20px;
                margin-left: 20px;
                width: 600px;
                height: 400px;
            }
        </style>

        <script>
            var mySidebar;
            var myForm;



            function doOnLoad() {

                mySidebar = new dhtmlXSideBar({
                    parent: "sidebarObj",
                    icons_path: "common/win_32x32/",
                    template: "tiles",
                    width: 300,
                    json: "json/sidebar.json",
                    onload: function () {

                        //ЗА ДНЕС


                        myLayoutToday = mySidebar.cells("today").attachLayout({
                            pattern: "2E",
                            cells: [{id: "a", text: "Задачи"}, {id: "b", text: "Плащания"}]
                        });
                        myMenuTodayTasks = myLayoutToday.cells("a").attachToolbar({
                            icons_path: "common/imgs/",
                            xml: "xml/toolbarToday.xml"
                        });

                        myMenuTodayPayments = myLayoutToday.cells("b").attachToolbar({
                            icons_path: "common/imgs/",
                            xml: "xml/toolbarToday.xml"
                        });

                        //myMenuTodayPayments.setWidth("mark", 50);



                        myGridTodayTasks = myLayoutToday.cells("a").attachGrid();
                        myGridTodayTasks.setImagePath("imgs/");
                        <?php include('getTodayTasks.php'); ?>
                        myGridTodayTasks.loadXML("xml/todayTasks.xml");
                        myGridTodayTasks.enableAlterCss("even", "uneven");

                        myMenuTodayTasks.attachEvent("onClick", function (id) {
                            if (id == "delete")
                            {
                               var selectionTodayTasks=myGridTodayTasks.getSelectedRowId();
                                                var valueCellTodayTasks=myGridTodayTasks.cells(selectionTodayTasks,0).getValue(); //На избрания ред, колона 0
                                                alert(valueCellTodayTasks);
                                                deleteTask(valueCellTodayTasks);
                                              //  myGridTodayTasks.deleteSelectedItem();
                                              updateGrids();
                            }
                            if (id == "complete")
                            {
                               var selectionTodayTasks=myGridTodayTasks.getSelectedRowId();
                                                var valueCellTodayTasks=myGridTodayTasks.cells(selectionTodayTasks,0).getValue(); //На избрания ред, колона 0
                                                alert(valueCellTodayTasks);
                                                completeTask(valueCellTodayTasks);
                                              //  myGridTodayTasks.deleteSelectedItem();
                                              updateGrids();
                            }
                            
                            
                });
                                
                             
                           
                        myGridTodayPayments = myLayoutToday.cells("b").attachGrid();
                        myGridTodayPayments.setImagePath("imgs/");
                        <?php include('getTodayPayments.php'); ?>
                        myGridTodayPayments.loadXML("xml/todayPayments.xml");
                        myGridTodayPayments.enableAlterCss("even", "uneven");
                         /*
                        myGridTodayPayments.filterBy(3, function (a) {
                            return (a == "Да");
                        }); */

                        myGridTodayPayments.attachEvent("onRowSelect", doOnRowSelectedTodayPayments);

                        myMenuTodayPayments.attachEvent("onClick", function (id) {
                            if (id == "delete")
                            {
                                var selectionTodayPayments = myGridTodayPayments.getSelectedRowId();
                                var valueCellTodayPayments = myGridTodayPayments.cells(selectionTodayPayments, 0).getValue(); //На избрания ред, колона 0
                                deletePayment(valueCellTodayPayments);
                                //myGridTodayPayments.deleteSelectedItem();
                                updateGrids();
                               
                            }
                             if (id == "complete")
                            {   
                                alert("Setting completed!")
                                var selectionTodayPayments = myGridTodayPayments.getSelectedRowId();
                                var valueCellTodayPayments = myGridTodayPayments.cells(selectionTodayPayments, 0).getValue(); //На избрания ред, колона 0
                                completePayment(valueCellTodayPayments);
                                //myGridTodayPayments.deleteSelectedItem();
                                updateGrids();
                            }

                        });

                //Нова задача
                
                        
                        
                        myForm = mySidebar.cells("addTask").attachForm();
                        myForm.loadStruct("json/form.json");
                        myForm.attachEvent("onButtonClick", function (id) {
                            if (id == "send") {
                                myForm.send("savingTask.php", "post", function (loader, response) {
                                    alert(response);
                                    updateGrids();
                                    clearmyForm();
                                   // myForm.updateValues();
                                });
                                
                            }
                            if (id == "clear") {
                                clearmyForm();
                            }
                        });
                        /*
                    myMenuTaskStat = mySidebar.cells("addTask").attachToolbar({
                                                icons_path: "common/imgs/",
                                                xml: "xml/toolbarTaskStat.xml"
                                            });
                                                */
                        //УПРАВЛЕНИЕ НА ЗАДАЧИ

                        myLayoutManage = mySidebar.cells("manageTasks").attachLayout({
                            pattern: "2E",
                            cells: [{id: "a", text: "Задачи", height: "190"}, {id: "b", text: "Преглед"}]
                        });



                        myMenu = mySidebar.cells("manageTasks").attachToolbar({
                            icons_path: "common/imgs/",
                            xml: "xml/toolbarUserPage.xml"
                        });
                        myMenu.addText("text_from", null, "За дата");
                        myMenu.addInput("date_from", null, "", 75);
                        // get inputs
                        input_from = myMenu.getInput("date_from");
                        input_from.setAttribute("readOnly", "true");
                        // init calendar
                        myCalendar = new dhtmlXCalendarObject([input_from]);
                        myCalendar.setDateFormat("%Y-%m-%d");
                        myCalendar.attachEvent("onHide", function () {
                            if (myMenu.getValue("date_from") != "") {
                                myGrid.filterBy(1, function (a) {
                                    return (a == myMenu.getValue("date_from"));
                                });
                            }
                        });




                        myMenu.attachEvent("onClick", function (id) {
                            if (id == "delete")
                            {
                                var selection = myGrid.getSelectedRowId();
                                myGrid.cells(selection, 1)
                                var valueCell = myGrid.cells(selection, 0).getValue(); //На избрания ред, колона 0
                                deleteTask(valueCell);
                               updateGrids();
                               clearMyFormView(); 
                            }

                            if (id == "reload") {
                                alert("reloading");
                                updateGrids();
                             }
                            if (id == "filterUrgent")
                                myGrid.filterBy(4, function (a) {
                                    return (a == "Да");
                                });
                            if (id == "filterOptional")
                                myGrid.filterBy(4, function (a) {
                                    return (a == "Не");
                                });
                            if (id == "filterFinished")
                                myGrid.filterBy(5, function (a) {
                                    return (a == "Да");
                                });
                            if (id == "filterUnfinished")
                                myGrid.filterBy(5, function (a) {
                                    return (a == "Не");
                                });
                        });


                        myGrid = myLayoutManage.cells("a").attachGrid();
                        myGrid.setImagePath("imgs/");
                        //HERE!!!
                        <?php include('getTasks.php'); ?>
                        myGrid.enableAlterCss("even", "uneven");
                        myGrid.loadXML("xml/text.xml");
                        myGrid.setEditable(true);
                        myGrid.attachEvent("onRowSelect", doOnRowSelected)


                        myFormView = myLayoutManage.cells("b").attachForm();
                        myFormView.loadStruct("json/formView.json");
                        //myFormView.hideItem("id",true);
                        myFormView.attachEvent("onButtonClick", function (id) {
                            if (id == "save") {
                                myFormView.send("updateTask.php", "post", function (loader, response) {
                                    alert(response);
                                    updateGrids();
                                    clearMyFormView(); 
                                });
                            }
                        })

                        //ДИАГРАМА НА ЗАДАЧИТЕ

                       
                        myLayoutTaskStat = mySidebar.cells("day").attachLayout({
                            pattern: "2E",
                            cells: [{id: "a", text: "Диаграма"}, {id: "b", text: "Диапазон от дни"}]
                        });
                        /*
                        myMenuTaskStat = myLayoutTaskStat.cells("a").attachToolbar({
                            icons_path: "common/imgs/",
                            xml: "xml/toolbarTaskStat.xml"
                        });
                        */

                        myFormStatTasks = myLayoutTaskStat.cells("b").attachForm();
                        myFormStatTasks.loadStruct("json/formStatTasks.json");
                        //myFormViewPayments.hideItem("id");
                        myFormStatTasks.attachEvent("onButtonClick", function (id) {
                            if (id == "go") {
                                alert('sending');
                                myFormStatTasks.send("getStatTasks.php", "post", function (loader, response) {
                                    alert(response);
                                    attachChartTasks();
                                });

                            }

                        })


                        //ДОБАВИ ПРИХОД/РАЗХОД
                        myFormInOut = mySidebar.cells("addInOut").attachForm();
                        myFormInOut.loadStruct("json/formInOut.json");
                        myFormInOut.attachEvent("onButtonClick", function (id) {
                            if (id == "send") {
                                myFormInOut.send("savingInOut.php", "post", function (loader, response) {
                                    alert(response);
                                    updateGrids();
                                });
                                clearMyFormInOut();
                            }
                        });



                        //УПРАВЛЕНИЕ НА ПЛАЩАНИЯ



                        myLayoutPayments = mySidebar.cells("managePayments").attachLayout({
                            pattern: "2E",
                            cells: [{id: "a", text: "Приходи и разходи", height: "190"}, {id: "b", text: "Преглед"}]
                        });



                        myGridPayments = myLayoutPayments.cells("a").attachGrid();
                        myGridPayments.setImagePath("imgs/");
<?php include('getPayments.php'); ?>
                        myGridPayments.enableAlterCss("even", "uneven");
                        myGridPayments.loadXML("xml/gridPayments.xml");
                        myGridPayments.setEditable(true);

                        myMenuPayments = mySidebar.cells("managePayments").attachToolbar({
                            icons_path: "common/imgs/",
                            xml: "xml/toolbarPayments.xml"
                        });

                        myMenuPayments.addText("text_from", null, "За дата");
                        myMenuPayments.addInput("date_from", null, "", 75);
                        // get inputs
                        input_from1 = myMenuPayments.getInput("date_from");
                        input_from1.setAttribute("readOnly", "true");
                        // init calendar
                        myCalendarPayments = new dhtmlXCalendarObject([input_from1]);
                        myCalendarPayments.setDateFormat("%Y-%m-%d");
                        myCalendarPayments.attachEvent("onHide", function () {
                            if (myMenuPayments.getValue("date_from") != "") {
                                myGridPayments.filterBy(2, function (a) {
                                    return (a == myMenuPayments.getValue("date_from"));
                                });
                            }
                        });


                        myMenuPayments.attachEvent("onClick", function (id) {
                            if (id == "delete")
                            {
                                var selectionPayments = myGridPayments.getSelectedRowId();
                                var valueCellPayments = myGridPayments.cells(selectionPayments, 0).getValue(); //На избрания ред, колона 0
                                deletePayment(valueCellPayments);
                                myGridPayments.deleteSelectedItem();
                                updateGrids();
                                clearMyFormViewPayments();
                            }

                            if (id == "reload")
                                
                                updateGrids();
                                
                            if (id == "incomes")
                                myGridPayments.filterBy(1, function (a) {
                                    return (a == "Приход");
                                });
                            if (id == "outcomes")
                                myGridPayments.filterBy(1, function (a) {
                                    return (a == "Разход");
                                });
                            if (id == "filterFinished")
                                myGridPayments.filterBy(5, function (a) {
                                    return (a == "Да");
                                });
                            if (id == "filterUnfinished")
                                myGridPayments.filterBy(5, function (a) {
                                    return (a == "Не");
                                });
                        });


                        myFormViewPayments = myLayoutPayments.cells("b").attachForm();
                        myFormViewPayments.loadStruct("json/formViewPayments.json");
                        //myFormViewPayments.hideItem("id");
                        myFormViewPayments.attachEvent("onButtonClick", function (id) {
                            if (id == "save") {
                                myFormViewPayments.send("updatePayments.php", "post", function (loader, response) {
                                    alert(response);
                                    updateGrids();
                                    clearMyFormViewPayments();
                                    });
                            }
                        })


                        myGridPayments.attachEvent("onRowSelect", doOnRowSelectedPayments)
                        
                        
                        
                        
                        //ДИАГРАМА НА ПЛАЩАНИЯТА


                        myLayoutPaymentStat = mySidebar.cells("calculate").attachLayout({
                            pattern: "2E",
                            cells: [{id: "a", text: "Диаграма"}, {id: "b", text: "Диапазон от дни"}]
                        });



                        myFormStatPayments = myLayoutPaymentStat.cells("b").attachForm();
                        myFormStatPayments.loadStruct("json/formStatPayments.json");
                        //myFormViewPayments.hideItem("id");
                        myFormStatPayments.attachEvent("onButtonClick", function (id) {
                            if (id == "go") {
                                alert('sending');
                                myFormStatPayments.send("getStatPayments.php", "post", function (loader, response) {
                                    alert(response);
                                    attachChartPayments();
                                });

                            }

                        })
                        
                        
                          //НАСТРОЙКИ
                        
                       
                        myFormSettingsB =mySidebar.cells("settings").attachForm();
                        myFormSettingsB.loadStruct("json/formSettingsB.json");
                        myFormSettingsB.attachEvent("onButtonClick", function (id) {
                            if (id == "send") {
                                myFormSettingsB.send("updateSettings.php", "post", function (loader, response) {
                                    alert(response);
                                    clearMyFormSettings();
                                    location.reload();
                                 
                                });
                             
                            }
                        }); 
                        
                        
                      
                    }
                });
            }


            function doOnRowSelected(id) {
                //alert("Rows with id: "+id+" was selected by user");

                var valueCellTitle = myGrid.cells(id, 2).getValue();
                myFormView.setItemValue("title", valueCellTitle);

                var valueCellDesc = myGrid.cells(id, 3).getValue();
                myFormView.setItemValue("description", valueCellDesc);

                var valueCellDate = myGrid.cells(id, 1).getValue();
                if (valueCellDate != "Безсрочна")
                    myFormView.setItemValue("date", valueCellDate);
                else
                    myFormView.setItemValue("date", "");


                if (myGrid.cells(id, 4).getValue() == "Да") {
                    myFormView.setItemValue("urgent", true);
                }

                var valueCellId = myGrid.cells(id, 0).getValue();
                myFormView.setItemValue("id", valueCellId);

                var completed;
                if (myGrid.cells(id, 5).getValue() == "Да")
                    completed = 1;
                else
                    completed = 0;
                myFormView.setItemValue("completed", completed);

                myFormView.disableItem("id");

            }

            function doOnRowSelectedPayments(id) {

                var valueCellDescPayments = myGridPayments.cells(id, 3).getValue();
                myFormViewPayments.setItemValue("description", valueCellDescPayments);

                var valueCellDate = myGridPayments.cells(id, 2).getValue();
                if (valueCellDate != "Безсрочна")
                    myFormViewPayments.setItemValue("date", valueCellDate);
                else
                    myFormViewPayments.setItemValue("date", "");

                var valueCellAmountPayments = myGridPayments.cells(id, 4).getValue();
                myFormViewPayments.setItemValue("amount", valueCellAmountPayments);

                var urgent;
                if (myGridPayments.cells(id, 5).getValue() == "Да")
                    urgent = 1;
                else
                    urgent = 0;
                myFormViewPayments.setItemValue("urgent", urgent);
                //HERE!!!
                var type;
                if (myGridPayments.cells(id, 1).getValue() == "Приход")
                    type = "1";
                else
                    type = "0";
                myFormViewPayments.setItemValue("type", type);

                var completed;
                if (myGridPayments.cells(id, 6).getValue() == "Да")
                    completed = 1;
                else
                    completed = 0;
                myFormViewPayments.setItemValue("completed", completed);


                var valueCellIdPayments = myGridPayments.cells(id, 0).getValue();
                myFormViewPayments.setItemValue("id", valueCellIdPayments);

                myFormViewPayments.disableItem("id");

            }


            function doOnRowSelectedTodayPayments() {
                var selectionTodayPayments = myGridTodayPayments.getSelectedRowId();
                var valueCellPayments = myGridTodayPayments.cells(selectionTodayPayments, 1).getValue(); //На избрания ред, колона 0
                var myMenuTodayPaymentsItem;
                if (valueCellPayments == "Приход")
                    myMenuTodayPaymentsItem = "Отбележи като получен";
                else
                    myMenuTodayPaymentsItem = "Отбележи като платен";
                myMenuTodayPayments.setItemText("mark", myMenuTodayPaymentsItem);
            }

            function deletePayment(id)
            {
                $.ajax({
                    type: 'POST',
                    data: {"paymentId": id},
                    url: 'deletePayment.php',
                    success: function (response) {
                        alert(response);
                        $("#return").text("result from php " + response); //poluchenata stoinost q slaga v <p>
                    }
                });
               
            }

           function deleteTask(id)
            {
                $.ajax({
                        type: 'POST',
                        data: {"taskId": id},
                        url: 'deleteTask.php',
                        success: function (response) {
                            alert(response);
                            $("#return").text("result from php " + response); //poluchenata stoinost q slaga v <p>
                            updateGrids();
                        }
                    });
                    
              }
              function completeTask(id)
            {
                $.ajax({
                        type: 'POST',
                        data: {"taskId": id},
                        url: 'setTaskCompleted.php',
                        success: function (response) {
                            alert(response);
                            $("#return").text("result from php " + response); //poluchenata stoinost q slaga v <p>
                            updateGrids();
                        }
                    });
                    
              }
              
              function completePayment(id)
            {
                $.ajax({
                        type: 'POST',
                        data: {"paymentId": id},
                        url: 'setPaymentCompleted.php',
                        success: function (response) {
                            alert(response);
                            $("#return").text("result from php " + response); //poluchenata stoinost q slaga v <p>
                            updateGrids();
                        }
                    });
                    
              }
              

            function attachChartTasks() {
                myChartTasks = myLayoutTaskStat.cells("a").attachChart({
                  
            view: "bar",
                    container: "chartDiv",
                    value: "#taskscount#",
                    gradient: "falling",
                    color: "#b9a8f9",
                    radius: 0,
                    alpha: 0.5,
                    border: true,
                    width: 70,
                    xAxis: {
                        template: "#date#",
                        title: "Задачи по дни"
                    },
                    yAxis: {
                        start: 0,
                        end: 10,
                        step: 1,
                    }
            
           
           
          
                });
                myChartTasks.load("xml/chartTasks.xml");
                myChartTasks.sort({
                    by: "#date#",
                    dir: "asc",
                    as: "string"
                });
            }
            
            function attachChartPayments() {
                myChartPayments = myLayoutPaymentStat.cells("a").attachChart({
                    view: "bar",
                    container: "chartDiv",
                    value: "#amount#",
                    gradient: "falling",
                    color: "#b9a8f9",
                    radius: 0,
                    alpha: 0.5,
                    border: true,
                    width: 70,
                    xAxis: {
                        template: "#date#",
                        title: "Плащания в суми"
                    },
                    yAxis: {
                        start: 0,
                        end: 1000,
                        step: 100,
                    }
                });
                myChartPayments.load("xml/chartPayments.xml");
                myChartPayments.sort({
                    by: "#date#",
                    dir: "asc",
                    as: "string"
                });
            }

            
            function updateGrids()
            {
                 alert("updating grids");
                myGridPayments.loadXML("xml/gridPayments.xml");
                myGridTodayPayments.loadXML("xml/todayPayments.xml");
                myGrid.loadXML("xml/text.xml");
                myGridTodayTasks.loadXML("xml/todayTasks.xml");
         /*       
        myGrid.updateFromXML("xml/text.xml");
                myGridTodayTasks.updateFromXML("xml/todayTasks.xml");*/
            }


           function clearmyForm()
           {
               myForm.setItemValue("id", "");
               myForm.setItemValue("title", "");
               myForm.setItemValue("description", "");
               myForm.setItemValue("date", "");
               myForm.setItemValue("name", "");
               myForm.setItemValue("urgent", false);
               myForm.setItemValue(name, value);
               
           }
           function clearMyFormView()
           {
               alert("clearing");
               myFormView.setItemValue("id", "");
               myFormView.setItemValue("title", "");
               myFormView.setItemValue("description", "");
               myFormView.setItemValue("date", "");
               myFormView.setItemValue("name", "");
               myFormView.setItemValue("urgent", false);
               myFormView.setItemValue("completed", false);
           }

            function clearMyFormViewPayments()
           {
               alert("clearing");
               myFormViewPayments.setItemValue("id", "0");
               myFormViewPayments.setItemValue("type", "1");
               myFormViewPayments.setItemValue("description", "");
               myFormViewPayments.setItemValue("date", "");
               myFormViewPayments.setItemValue("amount", "");
               myFormViewPayments.setItemValue("name", "");
               myFormViewPayments.setItemValue("urgent", false);
               myFormViewPayments.setItemValue("completed", false);
           }
           
           function clearMyFormInOut()
           {
               alert(  "clearing");
               myFormInOut.setItemValue("id", "0");
               myFormInOut.setItemValue("type", "1");
               myFormInOut.setItemValue("description", "");
               myFormInOut.setItemValue("date", "");
               myFormInOut.setItemValue("amount", "");
               myFormInOut.setItemValue("name", "");
               myFormInOut.setItemValue("urgent", false);
               myFormInOut.setItemValue("completed", false);
           }
           function clearMyFormSettings()
           {
               myFormSettingsB.setItemValue("background", "");
               myFormSettingsB.setItemValue("even", "");
               myFormSettingsB.setItemValue("uneven", "");
           }




        </script>
        
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
    </head>


    <body onload="doOnLoad();" bgcolor= <?php echo $_SESSION['background'] ?>>
<?php include('menu.php') ?> 
        <b> &nbsp; &nbsp; Здравейте, <?php echo $_SESSION['userfirst'] . " " . $_SESSION['userlast'] ?>  ! </b>
        <div id="sidebarObj">
            <form action="userPage.php" method="post" target="[some target]">
                <div id="myForm"></div>
            </form>   
        </div>


    </body>
</html>