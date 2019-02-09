
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
$("#carBookingForm").submit(function(e){
  e.preventDefault();
 var data= $(this).serialize();
 
 $.ajax({
  method: 'POST',
  url: "/car booking",
  data: data,
  success: function(data){
    $("#carBooking").modal('hide');
    $("#sucDiv").html(data);
    $("#sucDiv").fadeIn();
    $("#sucDiv").fadeOut(2000);
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

  loadUpdatingData('/cars/','car_id','plate_no','color','model','type','status','driver_id');
  validateCarUpdate();
  validateCarInsert();
  deleteData("/cars/");

  //new data insertion
  $("#insertForm").submit(function(e){
    e.preventDefault();
    if(validateCarInsert().valid()){
      $(".help-block").text('');
      if(!($(".error").text())){
          insertData('/cars/','plate_no','color','model','type','status');
        }
      }
  });
  //updating data
  $("#updateForm").submit(function(e){
    e.preventDefault();
  if(validateCarUpdate().valid()){
      if(!($(".error").text())){
        $(".help-block").text('');
        updateData('/cars/','plate_no','car_color','car_model','car_type','car_status','driver_id');
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

$("#searchForm").submit(function (e){
  e.preventDefault();
});

//all functions need for CRUD in JS

function updateData(url,inpName1,inpName2,inpName3,inpName4,inpName5,inpName6,inpName7,inpName8,inpName9,inpName10){
  var dataForUpdate = $("#updateForm").serialize();
  var id = $("#updateForm input:eq(1)").val();
  alert(id);
  if([inpName1,inpName2,inpName3,inpName4,inpName5,inpName6,inpName7,inpName8,inpName9,inpName10].indexOf('status')>=0){         }
        
 $.ajax({
    method: "PUT",
    url: url + id,
    data: dataForUpdate,
    success: function(data){
      console.log(data);

      if(data == "successfully updated"){
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
            if(data[1].indexOf('is assigned for driver')>=0){
              $('#updateForm .help-block:eq(5)').html('* ' +data[1]);
            }
          }

          if(!(typeof data[2]=="undefined")){
            if(data[2].indexOf('no driver registered')>=0){
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
      loadUpdatingData('/cars/','car_id','plate_no','color','model','type','status','driver_id');
      deleteData("/cars/");}

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
                loadUpdatingData('/cars/','car_id','plate_no','color','model','type','status','driver_id');
                deleteData('/cars/');
              }
            }

          });
      }
    }else{
      console.log(data);
     if(!(typeof data[inpName1]=="undefined")){$("#insertForm .help-block:eq(0)").html('* '+data[inpName1]);}
        if(!(typeof data[inpName2]=="undefined")){ $("#insertForm .help-block:eq(1)").html('* '+data[inpName2]);}
        if(!(typeof data[inpName3]=="undefined")){ $("#insertForm .help-block:eq(2)").html('* '+data[inpName3]);}}} });
}

function loadUpdatingData(urlN,inp1,inp2,inp3,inp4,inp5,inp6,inp7,inp8,inp9,inp10){  
  $(".updateBtn").click(function(e){
    e.preventDefault();
    var user_id = $(this).attr('id');
    $.ajax({
      method : "GET",
      url : urlN+user_id + "/edit" ,
      data: user_id,
      success: function(data) {
        console.log(data);
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
        if([inp1,inp2,inp3,inp4,inp5,inp6,inp7,inp8,inp9,inp10].indexOf('status')>=0){

          if(data['status']===false){
            
            $("#updateAbsent").addClass('active');
            $("#updatePresent").removeClass('active');
            $("#present").removeAttr('checked');
            $("#absent").attr('checked', 'checked');
          
          }else{
            
            $("#updateAbsent").removeClass('active');
            $("#updatePresent").addClass('active');
            $("#present").attr('checked','checked');
            $("#absent").removeAttr('checked');
          }
        }
        
      }
    });
    $("#updateModal").modal('show');
  });
}
validateCarBooking();
function validateCarBooking(){
  var validator = $("#carBookingForm").validate({
    rules:{
      destination: {required:true},
      pickup_time: {required:true,regex:/[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (2[0-3]|[01][0-9]):[0-5][0-9]/},
      return_time:{required:true,regex:/[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (2[0-3]|[01][0-9]):[0-5][0-9]/},
      open_drivers:{required:true},
      open_cars:{required:true}
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
        plate_no: {required:true,regex:/^[0-9]+$/,minlength:3,maxlength:6},
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
        plate_no :{required:true,regex:/^[0-9]+$/,minlength:3,maxlength:6},
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

      });
//end of jqery