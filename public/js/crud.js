
jQuery(document).ready(function(){
//errasing errors if buttons clicked
$("#cancel, #cancelUpdate,#insertButton,.updateBtn").click(function(){
  $("label.error").css('display','none');
});
//opening of insert form modal
$("#insertButton").click(function(e){
  $("#insertModal").modal('show');
});
//overflow same update alert
$('#sameUpdateModal').click(function(){
  $('body').css('overflow-y','auto')
});
//errasing conflict of error messages
$("#insertButton, .updateBtn").click(function(){
  $("#insertForm .help-block, #updateForm .help-block").html('');
});
//load update data and validation of insert and update form
var loc = window.location.href;
var locPath = window.location.pathname;
insertBooking();
function insertBooking(){
  $(".pending_table").submit(function(e){
    e.preventDefault();
    
  var dataForm = ($(this).serialize());
 
  $.ajax({
    method: "post",
    url: "/bookings/",
    data: dataForm,
    success:function(data){
      if(data.indexOf('Approved')>=0){
      element.fadeOut(1000);
     $("#errDiv").fadeOut();$("#sucDiv").html(data);  $("#sucDiv").fadeIn();
    }
    else{
     $("#sucDiv").fadeOut(); $("#errDiv").html(data); $("#errDiv").fadeIn();
     } 
    
    }
  });
  });
}
$("#bookACar").submit(function(e){
  e.preventDefault();
 var data= $(this).serialize();

 $.ajax({
  method: 'POST',
  url: "/bookings",
  data: data,
  success: function(data){
    console.log(data);
    // $("#carBooking").modal('hide');
    // $("#sucDiv").html(data);
    // $("#sucDiv").fadeIn();
    // $("#sucDiv").fadeOut(2000);
  }  
 });
 
 
 console.log(data);

});
if(loc.indexOf('driver')>=0){
  loadUpdatingData('/drivers/','driver_id','name','father_name','phone_no','status');
  validateDriverInsert();
  validateDriverUpdate();
  deleteData("/drivers/");
  //new data insertion
  $("#insertForm").submit(function(e){
    e.preventDefault();
    if(validateDriverInsert().valid()){
      if(!($(".error").text())){
          insertData('/drivers/','name','father_name','phone_no','status','driver_id');
      }
    }
  });
  //updating data
  $("#updateForm").submit(function(e){
    e.preventDefault();
  if(validateDriverUpdate().valid()){
      if(!($(".error").text())){
        updateData('/drivers/','driver_name','driver_father_name','driver_phone_no','driver_status');
      }
    }
  });
  //search part
  $("#searchInp").keyup(function(e){
    e.preventDefault();
  
    if($('#searchon option:selected').text()=="Search By"){
      $("#searchon").focus(); }else{searchData('post','/drivers/searchDriver/');}
  
  });
}
//for car page
else if(loc.indexOf('car')>=0){

  loadUpdatingData('/cars/','plate_no_for_update','plate_no','color','model','type','driver_id');
  validateCarUpdate();
  validateCarInsert();
  deleteData("/cars/");

  //new data insertion
  $("#insertForm").submit(function(e){
    e.preventDefault();
    if(validateCarInsert().valid()){
      $(".help-block").text('');
      if(!($(".error").text())){
          insertData('/cars/','plate_no','color','model','type','status','driver_id');
        }
      }
  });
  //updating data
  $("#updateForm").submit(function(e){
    e.preventDefault();
  if(validateCarUpdate().valid()){
      if(!($(".error").text())){
        $(".help-block").text('');
        updateData('/cars/','plate_no','car_color','car_model','car_type','driver_id','car_status');
      }
    }
  });
  //search part
  $("#searchInp").keyup(function(e){
    e.preventDefault();
    if($('#searchon option:selected').text()=="Search By"){$("#searchon").focus(); }
    else{searchData('POST','/cars/searchCar/');}
  });
}
else if(locPath == '/users'){  
  validateUserInsert();
  loadUpdatingData('/users/','id','position','directorate','status');
  validateUserUpdate();
  deleteData("/users/");

  //new data insertion
  $("#insertForm").submit(function(e){
    e.preventDefault();
    if(validateUserInsert().valid()){
      $(".help-block").text('');
      if(!($(".error").text())){
          insertData('/users/','position','directorate','status');
        }
      }
  });
  // updating data
  $("#updateForm").submit(function(e){
    e.preventDefault();
  if(validateUserUpdate().valid()){
      if(!($(".error").text())){
        $(".help-block").text('');
        updateData('/users/','status');
      }
    }
  });
  
  // search part
  $("#searchInp").keyup(function(e){
    e.preventDefault();
    if($('#searchon option:selected').text()=="Search By"){$("#searchon").focus(); }
    else{searchData('POST','/users/searchUser/');}
  });
  
}
else if(locPath == '/home'){  
  $(".passBtn").click(function(e){
    e.preventDefault();
    $("#passModal").modal('show');
  });
  validateUserInsert();
  loadUpdatingData('/users/','id','position','directorate','status');
  validateUserUpdate();
  deleteData("/users/");

  //new data insertion
  $("#insertForm").submit(function(e){
    e.preventDefault();
    if(validateUserInsert().valid()){
      $(".help-block").text('');
      if(!($(".error").text())){
          insertData('/users/','position','directorate','status');
        }
      }
  });
  // updating data
  $("#updateForm").submit(function(e){
    e.preventDefault();
  if(validateUserUpdate().valid()){
      if(!($(".error").text())){
        $(".help-block").text('');
        updateData('/users/','status');
      }
    }
  });
  
  // search part
  $("#searchInp").keyup(function(e){
    e.preventDefault();
    if($('#searchon option:selected').text()=="Search By"){$("#searchon").focus(); }
    else{searchData('POST','/users/searchUser/');}
  });
  
}
else if(locPath == "/pendings_users"){
  loadUpdatingData('/users/','id');

  $("#updateForm").submit(function(e){
    e.preventDefault();
    alert('submit');
    updateData('/approveUser/','id','status');
  });
}
else if(locPath == "/user_roles"){
 
      loadUpdatingData('/roles/','id','name','role_name');
      $("form#updateForm").submit(function(e){
        e.preventDefault();
        updateData('/roles/','id','role_id');
      });
}
else if(locPath == "/user_permissions"){
 
      loadUpdatingData('/permissions/','id','name','permission_name');
      $("form#updateForm").submit(function(e){
        e.preventDefault();
        updateData('/permissions/','id','permission_name');
      });
}
else if(locPath =='/pending_bookings'){
  $('.updateBtn').click(function(e){
    e.preventDefault();
    $('#updateModal').show();
  });
 }
else if(loc.indexOf('booking')>=0){
 loadBookingUpdatingData();
}



$("#searchForm").submit(function (e){
  e.preventDefault();
});

//all functions need for CRUD in JS

function updateData(url,inpName1,inpName2,inpName3,inpName4,inpName5,inpName6,inpName7,inpName8,inpName9,inpName10){
  var dataForUpdate = $("#updateForm").serialize();
  var id = $("#updateForm input:eq(1)").val();
  
  console.log(dataForUpdate);
  alert('helloFrom update');
 $.ajax({
    method: "PUT",
    url: url + id,
    data: dataForUpdate,
    success: function(data){
      console.log(data);

      if(data.indexOf("successfully")>=0 || data.indexOf('pending')>=0||data.indexOf("role/roles remvoed")>=0){
        $("#sucDiv").html(data);
        $("#updateModal").modal('hide');
        $("#sucDiv").fadeIn(100);
        $("#sucDiv").fadeOut(2000);
        $('#updateForm').trigger('reset');
      }else{
        
        if(typeof data ==='string' || data instanceof String){
          if(data.indexOf('nothing for update')>=0 ){
            $('#messageContent').html(data);
            $('#updateModal').modal('hide');
            $('body').css('overflow','hidden');
            $('#noUpdateModal').modal('show');
             }else{
                  if(data.indexOf("phone no has already been taken")>=0){
                  $("#updateForm .help-block:eq(2)").html("* "+data);}

                  if(data.indexOf("there is no driver")>=0){
                    $("#updateForm .help-block:eq(5)").html("* "+data);
                  } 
              }
           }else{
          if(!(typeof data[0]=="undefined")){
            if(data[0].indexOf("plate number")>=0){
              $("#updateForm .help-block:eq(0)").html("* "+data[0]);}
            }
          if(!(typeof data[1]=="undefined")){
            if(data[1].indexOf('there is no driver exist with this id')>=0){
              $('#updateForm .help-block:eq(5)').html('* ' +data[1]);
            }
          }

          if(!(typeof data[2]=="undefined")){
            if(data[2].indexOf('no driver registered')>=0){
              alert(data[2]);
              $('#updateForm .help-block:eq(5)').html("* "+data[2]);
            }
          }
          
        if(!(typeof data[inpName1]=="undefined")){
          $("#updateForm .help-block:eq(0)").html('* '+data[inpName1]);}

        if(!(typeof data[inpName2]=="undefined")){
          $("#updateForm .help-block:eq(1)").html('* '+data[inpName2]);}

        if(!(typeof data[inpName3]=="undefined")){
          $("#updateForm .help-block:eq(2)").html('* '+data[inpName3]);}
        
        if(!(typeof data[inpName4]=="undefined")){
          $("#updateForm .help-block:eq(3)").html('* '+data[inpName4]);}
      
        if(!(typeof data[inpName5]=="undefined")){
          $("#updateForm .help-block:eq(4)").html('* '+data[inpName5]);}
      
        if(!(typeof data[inpName6]=="undefined")){
          $("#updateForm .help-block:eq(5)").html('* '+data[inpName6]);}
      
        if(!(typeof data[inpName7]=="undefined")){
          $("#updateForm .help-block:eq(6)").html('* '+data[inpName7]);}

        if(!(typeof data[inpName8]=="undefined")){
          $("#updateForm .help-block:eq(7)").html('* '+data[inpName8]);} 

        if(!(typeof data[inpName9]=="undefined")){
          $("#updateForm .help-block:eq(8)").html('* '+data[inpName9]);}  

        if(!(typeof data[inpName10]=="undefined")){
          $("#updateForm .help-block:eq(9)").html('* '+data[inpName10]);}
        }
      }
    }
  });
} 

function deleteData(url){
  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
  $('.deleteBtn').click(function deleteID(e){
    e.preventDefault();
    var deleteId= $(this).attr('id');
    var x = 1; 
    $("#deleteModal").modal('show');
    $("#yesBtn").click(function(){
      if(x == 1){
        x++;
       $.ajax({
          method: 'DELETE',
          url: url + deleteId,
          success: function(data){
            if(data.indexOf('successfully deleted')>=0){
                $("#deleteModal").modal('hide');
                $('#'+deleteId).closest('tr').css({'pointer-events':'none'});
                $("#"+deleteId).closest('tr').fadeOut(500);
                $("#errDiv").fadeOut();
              }
            else{
              $("#deleteModal").modal('hide');
              $('#errDiv').html('deletion not occured, please try again');
              $("#errDiv").fadeIn();
            } 
            console.log(data);
          }
        });}
     });
  });
}
function searchData(method,url){
  var data =  $("#searchForm").serialize();
  
  $.ajax({
    method: method,
    url: url+data,
    data: data,
    success: function(data){
      $(".tableOfDriver").empty();
      if(data == "Data not found!"){
        $("#driverTable").hide();
        $("#notFound").fadeIn();
      }else{
      $(".tableOfDriver").html(data);
      if(loc.indexOf('driver')>=0){
      loadUpdatingData('/drivers/','driver_id','name','father_name','phone_no','status');
      deleteData("/drivers/");}
      else if(loc.indexOf('car')>=0){
      loadUpdatingData('/cars/','plate_no_for_update','plate_no','color','model','type','driver_id');
      deleteData("/cars/"); }
      else if(loc.indexOf('user')>=0){
        loadUpdatingData('/users/','id','position');
        deleteData('/users/');
      }

      }
    }
  });
}

function insertData(url,inpName1,inpName2,inpName3,inpName4,inpName5,inpName6,inpName7,inpName8,inpName9,inpName10){
  var dataOfDriver = $("#insertForm").serialize();
  console.log(dataOfDriver);
  $.ajax({
    method : "POST", url : url, data : dataOfDriver, cache: false,
    success: function(data){
      console.log(data);
      if(typeof data ==="string"){ 
        if(data.match("done")){
          var id = data.match(/\d+/g); 
          $("#insertModal").modal('hide'); 
          $("#sucDiv").fadeIn(); 
          $("#insertModal").modal('hide');
          $("#sucDiv").text(data); 
          $("#sucDiv").fadeOut(2000); 
          $("#insertForm").trigger('reset');
          $.ajax({method: "GET",  url: url+id,  success: function(data){  
              $(data).insertAfter("#dataTable tr:first"); 
              if(url.indexOf('driver')>=0){
             loadUpdatingData('/drivers/','driver_id','name','father_name','phone_no','status')
              deleteData("/drivers/");}
              if(url.indexOf('car')>=0){
                loadUpdatingData('/cars/','plate_no_for_update','plate_no','color','model','type','driver_id');
                deleteData('/cars/');
              }
            }

          });
      }
    }else{
      console.log(data);
     if(!(typeof data[inpName1]=="undefined")){$("#insertForm .help-block:eq(0)").html('* '+data[inpName1]);}
        if(!(typeof data[inpName2]=="undefined")){ $("#insertForm .help-block:eq(1)").html('* '+data[inpName2]);}
        if(!(typeof data[inpName3]=="undefined")){ $("#insertForm .help-block:eq(2)").html('* '+data[inpName3]);}
        
     if(!(typeof data[inpName4]=="undefined")){$("#insertForm .help-block:eq(3)").html('* '+data[inpName4]);}
     
     if(!(typeof data[inpName5]=="undefined")){$("#insertForm .help-block:eq(4)").html('* '+data[inpName5]);}
     if(!(typeof data[inpName6]=="undefined")){$("#insertForm .help-block:eq(5)").html('* '+data[inpName6]);}
     
     alert(data[inpName8]);
     if(!(typeof data[inpName8]=="undefined")){$("#insertForm .help-block:eq(6)").html('* '+data[inpName8]);}
      
      
      }} });
}
function loadUpdatingData(urlN,inp1,inp2,inp3,inp4,inp5,inp6,inp7,inp8,inp9,inp10){  
  $(".updateBtn").click(function(e){
    e.preventDefault();
    $("input[type='checkbox']").prop('checked',false);
    var id = $(this).attr('id');
    
    $.ajax({
      method : "GET",
      url : urlN+id + "/edit" ,
      data: id,
      success: function(data) {
        console.log(data);
        if(loc.indexOf("user_roles")>=0){  
          
          for(i=0;i<data.length;i++){ 
           console.log(data[i][inp3]);
            $("input[value='"+data[i][inp3]+"'").prop("checked", true); 
         }
          console.log(data[0][inp1]);
        console.log(data[0][inp2]);
        console.log(data[0][inp3]);
        

      $("#updateForm input:eq(1)").val(data[0][inp1]);
      $("#id").text(data[0][inp1]);
      $("#name").text(data[0][inp2]);
     
      }
      else if(loc.indexOf('user_permissions')>=0){
        
        for(i=0;i<data.length;i++){ 
          console.log(data[i][inp3]);
           $("input[value='"+data[i][inp3]+"'").prop("checked", true); 
        }
         console.log(data[0][inp1]);
       console.log(data[0][inp2]);
       console.log(data[0][inp3]);
       

     $("#updateForm input:eq(1)").val(data[0][inp1]);
     $("#id").text(data[0][inp1]);
     $("#name").text(data[0][inp2]);
      }
      
      else{        
        $("#updateForm input:eq(1)").val(data[inp1]);
        $("#updateForm input:eq(2)").val(data[inp2]);
        $("#updateForm input:eq(3)").val(data[inp3]);
        $("#updateForm input:eq(4)").val(data[inp4]);
        $("#updateForm input:eq(5)").val(data[inp5]);
        $("#updateForm input:eq(6)").val(data[inp6]);
        $("#updateForm input:eq(7)").val(data[inp7]);
        $("#updateForm input:eq(8)").val(data[inp8]);
        $("#updateForm input:eq(9)").val(data[inp9]);
        $("#updateForm input:eq(10)").val(data[inp10]);
      }
        
      }
    });
    $("#updateModal").modal('show');
  });
}
validateVehicalBook();
function validateVehicalBook(){
  var validator = $("#bookACar").validate({
    rules:{
      destination: {required:true},
      pickup_time: {required:true,regex:/[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (2[0-3]|[01][0-9]):[0-5][0-9]/},
      return_time:{required:true,regex:/[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (2[0-3]|[01][0-9]):[0-5][0-9]/},
      description:{required:true},
      
    },
    messages:{
      pickup_time:{
        regex: "date form is like 2019-01-01 01:00",
      },
      return_time:{
        regex: "date form is like 2019-01-01 01:00",
      }
    }
  });
  return validator;
}
function validateCarUpdate(){
    var validator = $("#updateForm").validate({ 
      rules: {
        plate_no: {required:true,required:true,regex:/^[0-9]+$/, range:[100,999999]},
        car_color: {required:true,minlength:3},
        car_status: {required:true},
        car_type: {required:true},
        car_model: {required:true},
        
      }, 
      messages:{
        plate_no:{
          regex: "please insert a valid number plate for example 44928"
        }
      } 
    });
    return validator;
}
function validateCarInsert(){
    var validator = $("#insertForm").validate({ 
      rules: {
        plate_no :{required:true,regex:/^[0-9]+$/, range:[100,999999]},
        color: {required:true,minlength:3},
        status :{required:true},
        type :{required:true},
        model :{required:true},
        
      }, 
      messages:{
        plate_no:{
          regex: "please insert a valid number plate for example 44928"
        }
      } 
    });
    return validator;
}
function validateDriverInsert(){
    var validator = $("#insertForm").validate({ 
      rules: {
        name :{required:true,regex:/^[a-zA-Z_-\s]+$/,minlength:3},
        father_name: {required:true,regex:/^[a-zA-Z_-\s]+$/,minlength:3},
        phone_no :{required:true,  regex: /^07[0-9]{8}$/},
      }, 
      messages:{
        name:{
          regex: "using of alphabets, spaces, and - _ is allowed"
        },
        father_name:{
          regex: "using of alphabets, spaces, and - _ is allowed"
        }
      } 
    });
    return validator;
}

function validateDriverUpdate(){
    var validatorUpdate = $("#updateForm").validate({ 
      rules: {
        driver_name :{required:true,regex:/^[a-zA-Z_-\s]+$/,minlength:3},
        driver_father_name: {required:true,regex:/^[a-zA-Z_-\s]+$/,minlength:3},
        driver_phone_no :{required:true,  regex: /^07[0-9]{8}$/},
      }, 
      messages:{
        driver_name:{
          regex: "using of alphabets, spaces, and - _ is allowed"
        },
        driver_father_name:{
          regex: "using of alphabets, spaces, and - _ is allowed"
        }
    } 
  });
  return validatorUpdate;
}
function validateUserInsert(){
  var validator = $("#insertForm").validate({ 
    rules: {
      phone :{required:true,regex: /^07[0-9]{8}$/},
      email: {required:true,email:true},
      password :{required:true,regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/},
      position :{required:true},
      directorate :{required:true},
      name :{required:true},
      password_confirmation :{required:true,equalTo:"#password"},
      
    }, 
    messages:{
      plate_no:{
        regex: "please insert a valid number plate for example 44928"
      },
      password:{
        regex: "Minimum eight characters, at least one letter, one number and one special character",
      },
    } 
  });
  return validator;
}
function validateUserUpdate(){
  var validator = $("#updateForm").validate({ 
    rules: {
      phone :{required:true,regex: /^07[0-9]{8}$/},
      email: {required:true,email:true},
      password :{required:true,regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/},
      position :{required:true},
      directorate :{required:true},
      name :{required:true},
      password_confirmation :{required:true,equalTo:"#password"},
      
    }, 
    messages:{
      plate_no:{
        regex: "please insert a valid number plate for example 44928"
      },
      password:{
        regex: "Minimum eight characters, at least one letter, one number and one special character",
      },
    } 
  });
  return validator;
}   
$("input[name='reject']").click(function(){
    
  var id = $(this).closest('form').children("input[name='booking_id']").val();
  var approval = $(this).closest('form').children("div").children('div').children("select[name='approval']");
  var pickup_time = $(this).closest('form').children('div').find("input[name='approval_pickup_time']");
  var return_time = $(this).closest('form').children('div').find("input[name='approval_return_time']");
  var approver_description = $(this).closest('form').children('div').find("textarea[name='approver_description']");
  var plate_no = $(this).closest('form').children('div').find("select[name='plate_no']");
  var driver_id = $(this).closest('form').children('div').find("select[name='driver_id']");
  approval.val('false');
  pickup_time.val('');
  return_time.val('');
  plate_no.val('null');
  driver_id.val('null');
   var txt_msg = approver_description.val();

  if (txt_msg.replace(/^\s+|\s+$/g, "").length == 0 || txt_msg==""||txt_msg.replace(/^\s+|\s+$/g, "").length <=9) {  
      approver_description.siblings('div').html("<p class='text-danger'>at least 10 characters for case of rejection is required</p>");
      approver_description.css('border','1px solid red');
      approver_description.focus();
    return false;
      }
      else{
        approver_description.siblings('div').html('');
        approver_description.css('border','1px solid #ced4da');
        var formData = $(this).closest('form').serialize();
        
       var divHide = $(this).closest('form').parent('div').parent('div');
       
      
    $.ajax({
      method: "PUT",
      url: "/bookings/"+id,
      data: formData,
      success: function(data){
        if(data.indexOf('rejected')>=0){
        divHide.fadeOut(1500);
        $('#sucDiv').html(data);
        $('#sucDiv').fadeIn();
        $('#sucDiv').fadeOut(3000);}
        console.log(data);
      }  });  
  }
   });
      
$(".pending_book_form").submit(function(e){
  e.preventDefault();
  var id = $(this).children("input[name='booking_id']").val();
  console.log("this is you want: "+id);
  var formData = $(this).serialize();
 var divFadeOut = $(this).parent('div').parent('div');
 alert(id);
  console.log(formData);
  $.ajax({
    method: "PUT",
    url: "/bookings/"+id,
    data: formData,
    success: function(data){
      divFadeOut.fadeOut(1500);
      $("#sucDiv").html(data);
      $("#sucDiv").fadeIn();
      $("#sucDiv").fadeOut(3000);
      console.log(data);
    }
  });
});

function loadBookingUpdatingData(){  
  $(".updateBtn").click(function(e){
  $("#plate_no").val();
    e.preventDefault();
    var id = $(this).attr('id');
    alert(id);
    $.ajax({
      method : "GET",
      url : "/bookings/"+id + "/edit" ,
      data: id,
      success: function(data) {
        console.log(data);
      
      $('#plate_no').find('option').remove().end().append("<option value='"+data['bookings']['plate_no']+"'>"+data['bookings']['plate_no']+"</option>");
      $("#approval").find('option').remove().end().append("<option value='"+data['bookings']['approval']+"'>"+data['bookings']['approval']+"</option>")
      $("#driver_id").find('option').remove().end().append("<option value='"+data['bookings']['driver_id']+"'>"+data['bookings']['driver_id']+"</option>")
      if(data['bookings']['approval']==null){
        $("#approval").append("<option value='true'>true</option>");
        $("#approval").append("<option value='false'>false</option>");
      }
      if(data['bookings']['approval']==true){
        
        $("#approval").append("<option value='false'>false</option>");
      }
      if(data['bookings']['approval']==false){
        $("#approval").append("<option value='true'>true</option>");
        
      }

      
      // $("#plate_no").val(data['plate_no']);
        // $("#plate_no").append("<option selected value='"+data['plate_no']+"'>"+data['plate_no']+"</option>");
        $("#approval_pickup_time").val(data['bookings']['approval_pickup_time']);
        $("#approval_return_time").val(data['bookings']['approval_return_time']);
        $("#approver_description").val(data['bookings']['approver_description']);
        
      }
    });
    $("#updateModal").modal('show');
  });
}
      });
//end of jqery