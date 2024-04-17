$(document).ready(function () {

    if ($('#label1').length > 0) {
        console.log("Element with ID 'label1' found");
    } else {
        console.log("Element with ID 'label1' not found");
    }
    

    function showMessage(message) {
        // Set the text content of the message div
        $('#messageDiv').text(message);
        
        // Fade in the message div
        $('#messageDiv').fadeIn('slow', function() {
            // After fade in, set a timeout to fade out the message div
            setTimeout(function() {
                $('#messageDiv').fadeOut('slow');
            }, 2000); // Adjust the duration as needed (here it fades out after 2 seconds)
        });
    }



  

    function autoExecute() {
        $.ajax({
            type: "GET",
            url: "http://localhost/crud/db.php",
            success: function (response) {
                setTimeout(function () {
                    $('.navbar').addClass('orange');
                    showMessage("Database Available");
                    

                }, 2000);

                

            },
            error: function (xhr, status, error) {
                console.log('error', error);
            }
        });
    }

    autoExecute();

    $('.testing').click(function () {


    });

    var boxWidth = $('.box').outerWidth();

    // Set the width of .box-2 to match that of .box
    $('.box-2').css('width', boxWidth + 'px');

    var tableName;

    
    
    
    function insertData(event) {
       
        event.preventDefault();

 
        tableName = $('#tab_name').val();
        console.log(tableName); 

       
        var formData = $('#form').serialize();
        console.log(formData);

    
        $.ajax({
            type: "POST",
            url: "http://localhost/crud/post_data.php",
            data: formData,
            success: function (response) {
              
                console.log(response);



                $('.form-creation').fadeOut('slow', function () {
                    $(this).hide();
                    $('.blog').animate({
                        'margin-top': '-60px' 
                    }, 'slow');
                    $('.field-whole').show().animate({
                        'margin-top': '-20px' 
                    }, 'slow');
                    $('.table-container').show().animate({
                    }, 'slow');
                    
                });
                
                $('.tab-text').fadeOut('slow', function () {
                    $(this).hide();
                });
                
                
                getTableStructure(tableName);

                // Show the "Table Created" message
                showMessage("Table Created");
            },
            error: function (xhr, status, error) {
                // Handle the error response
                console.error(xhr.responseText);
                alert("Error occurred while creating table. Please try again.");
            }
        });
    }

    // Attach click event listener to the create button
    $('#create').click(function (event) {
        insertData(event); // Call the insertData function and pass the event object
    });



    

    function getTableStructure(tableName) {

        console.log('the table name is:' + tableName);
        $.ajax({
            type: "GET",
            url: "http://localhost/crud/structure.php",
            data: { tableName: tableName }, // Pass the tableName parameter
            success: function (response) {
                // Split the response string by commas to get an array of field names
                var fieldNames = response.split(',');
                
                // Update the tab name
                $('.tab-name').text('Table: ' + tableName);
    
                // Assign the field names to the labels
                for (var i = 0; i < fieldNames.length; i++) {
                    $('#label' + (i + 1)).text(fieldNames[i]);
                    $('#tlabel' + (i + 1)).text(fieldNames[i]);

                }

                
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                alert("Error occurred while fetching table structure. Please try again.");
            }
        });
    }

    function insertRecord(event) {
        event.preventDefault();
        var formData = $('#form1').serialize();
        console.log(formData);
    
        $.ajax({
            type: "POST",
            url: "http://localhost/crud/insertData.php",
            data: {
                tableName: tableName, // Updated key to match PHP script
                formData: formData
            },
            success: function (response) {
                // Parse the JSON response
                var fieldNames = response.split(',');

                for (var i = 0; i < fieldNames.length; i++) {
                    console.log(fieldNames[i]);
                }

                var newRow = $('<tr>');

                // Populate the new row with form values
                fieldNames.forEach(function (value) {
                    newRow.append($('<td>').text(value));
                });

                // Append the new row to the table's tbody
                $('#data-table tbody').append(newRow);

                $('#form1')[0].reset();
    
                // Show a success message
                showMessage("Record Inserted");
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                alert("Error occurred while inserting record. Please try again.");
            }
        });
    }
    

    // Attach click event listener to the create button
    $('#insertRecordButt').click(function (event) {
        insertRecord(event); // Call the insertRecord function and pass the event object
    });

 





});
