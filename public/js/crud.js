
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
if(loc.indexOf('driver')>=0){
  loadDriverUpdatingData('/drivers/','driver_id','name','father_name','phone_no','status');
  validateDriverInsert();
  validateDriverUpdate();
  deleteDriverData("/drivers/");
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
    if($('#searchon option:selected').text()=="Search By"){$("#searchon").focus(); }else{searchData('post','/drivers/searchDriver/');}
  });
}
//for car page
else if(loc.indexOf('car')>=0){

  // loadDriverUpdatingData('/cars/','driver_id','name','father_name','phone_no','status');
  // validateDriverInsert();
  // validateDriverUpdate();
  // deleteDriverData("/cars/");

  //new data insertion
  $("#insertForm").submit(function(e){
    // alert('hello');
    // e.preventDefault();
          insertData('/cars/','plate_no','color','model','type','status');
  });
  //updating data
  $("#updateForm").submit(function(e){
    e.preventDefault();
  // if(validateDriverUpdate().valid()){
      // if(!($(".error").text())){
        updateData('/cars/','driver_name','driver_father_name','driver_phone_no','driver_status');
      // }
    // }
  });
  //search part
  $("#searchInp").keyup(function(e){
    e.preventDefault();
    if($('#searchon option:selected').text()=="Search By"){$("#searchon").focus(); }else{searchData('post','/cars/searchDriver/');}
  });
}

$("#searchForm").submit(function (e){
  e.preventDefault();
});

function loadData(){
  $.ajax({
    method: "GET",
    url: "/drivers",
    success: function(data){
    
    }
  });
}
//all functions need for CRUD in JS

function updateData(url,inpName1,inpName2,inpName3,inpName4,inpName5,inpName6,inpName7,inpName8,inpName9,inpName10){
  var dataForUpdate = $("#updateForm").serialize();
  var id = $("#updateForm input:eq(1)").val();
  if([inpName1,inpName2,inpName3,inpName4,inpName5,inpName6,inpName7,inpName8,inpName9,inpName10].indexOf('status')>=0){

              if($("#present").prop("checked",true)){
            $("input[name='driver_status']").val('true');
          
          }else{
            $("input[name='driver_status']").val('false');
          }
        }
        
        
 $.ajax({
    method: "PUT",
    url: url + id,
    data: dataForUpdate,
    success: function(data){
      if(data == "successfully updated"){
        $("#sucDiv").html(data);
        $("#updateModal").modal('hide');
        $("#sucDiv").fadeIn(100);
        $("#sucDiv").fadeOut(2000);
        $('#updateForm').trigger('reset');
      }else{
        console.log(data);
        if(typeof data ==='string' || data instanceof String){
          if(data.indexOf('nothing for update')>0 ){
            $('#messageContent').html(data);
            $('#updateModal').modal('hide');
            $('body').css('overflow','hidden');
            $('#noUpdateModal').modal('show');
             }else{
              if(data.indexOf("phone no has already been taken")>=0){
              $("#updateForm .help-block:eq(2)").html("* "+data);
                   }
                  }
                   console.log(data);
           }else{

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
function deleteDriverData(url){
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
  var dataOfDriver =  $("#searchForm").serialize();
  $.ajax({
    method: method,
    url: url+dataOfDriver,
    data: dataOfDriver,
    success: function(data){
      $(".tableOfDriver").empty();
      if(data == "Data not found!"){
        $("#driverTable").hide();
        $("#notFound").fadeIn();
      }else{
      $(".tableOfDriver").html(data);

      loadDriverUpdatingData('/drivers/','driver_id','name','father_name','phone_no','status');
      
      deleteDriverData("/drivers/");
      }
    }
  });
}

function insertData(url,inpName1,inpName2,inpName3,inpName4,inpName5,inpName6,inpName7,inpName8,inpName9,inpName10){
  var dataOfDriver = $("#insertForm").serialize();
  $.ajax({
    method : "POST", url : url, data : dataOfDriver, cache: false,
    success: function(data){
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
             loadDriverUpdatingData('/drivers/','driver_id','name','father_name','phone_no','status')
              deleteDriverData("/drivers/");}
            }
          });
      }
    }else{
      console.log(data);
     if(!(typeof data[inpName1]=="undefined")){$("#insertForm .help-block:eq(0)").html('* '+data[inpName1]);}
        if(!(typeof data[inpName2]=="undefined")){ $("#insertForm .help-block:eq(1)").html('* '+data[inpName2]);}
        if(!(typeof data[inpName3]=="undefined")){ $("#insertForm .help-block:eq(2)").html('* '+data[inpName3]);}}} });
}

function loadDriverUpdatingData(urlN,inp1,inp2,inp3,inp4,inp5,inp6,inp7,inp8,inp9,inp10){  
  $(".updateBtn").click(function(e){
    e.preventDefault();
    var user_id = $(this).attr('id');
    $.ajax({
      method : "GET",
      url : urlN+user_id + "/edit" ,
      data: user_id,
      success: function(data) {
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