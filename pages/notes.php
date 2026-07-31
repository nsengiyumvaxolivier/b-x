<?php
include("./connection.php");
$business=$_SESSION['user'];
$selectnotes=$conn->prepare("SELECT * FROM notes where business=? order by created_at desc");
$selectnotes->bind_param("i",$business);
$selectnotes->execute();
$noteresult=$selectnotes->get_result();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container-fluid bg-gray-200 p-1 h-[100%]">
        <div class="h-[100%]"> 
            <div class="top bg-yellow-900 h-[7%] sticky text-white flex p-1 justify-between"><h1 class="text-sm font-bold p-1 hidden md:block"> <i class="bi bi-sticky-fill"></i> Note List</h1> <div class="search bg-white p-1 w-[70%] md:w-1/2 rounded flex"><input type="text" name="search" placeholder="search Notes" class="w-[80%] text-black outline-none text-sm" id="filter"><button type="button" class="w-[20%] bg-gray-200 outline-none flex justify-center text-black" id="find"> <i class="bi bi-search"></i> <span class="hidden md:block p-0 px-1 m-0 w-[fit-content] text-black">Search</span></button></div><a href="addnotes" class="bg-green-500 text white rounded p-1 shadow-green-500 border border-green-500 hover:bg-green-400"> <i class="bi bi-plus-circle"></i> Add Note</a></div>
           <div class="notes p-1 h-[93%] overflow-y-auto " id="notes">
           
            
           </div>
        </div>
    </div>
</body>
</html>
<script>
    function editnotes(noteid) {
        window.location="editnotes?note="+noteid;
    }

       //delete button...........................................
    function deletenote(noteid){
        var choise = confirm("Are Your Sure You Want To Delete This Note ?");
        if (choise==true) {
            $.ajax({
                url:"./apis/deletenote.php",
                type:"Post",
                dataType:"json",
                data:{note:noteid},
                success:function(response){
                           alert(response);
                           window.location="notes";
                }
            })
        }
        else{
            alert("Note Not Deleted ");
            return false;
        }
    }
//load data..................................................................
    function loaddata(filters){

                        $.ajax({
                            url:'./apis/selectnotes.php',
                            type:'post',
                            dataType:'json',
                            data:{filter:filters},
                            success:function(data){
                                var notes=$("#notes");
                                var row="";
                            notes.empty();  
                           $.each(data,function(index,note){
                            
                            var row ="<div class='p-1 w-full my-2 shadow p-auto rounded bg-white'><div class='w-full bg-gray-200 text-sm flex justify-between font-bold p-1'><h1> <i class='bi bi-book'></i>"+"   ~"+note.title+"</h1><p class='flex gap-3'><button type='button' onClick='editnotes("+note.note_id+")' class='bg-blue-500 text-white font-bold rounded p-1'> <i class='bi bi-pen'></i> Edit</button><button type='button' onClick='deletenote("+note.note_id+")' class='bg-red-500 text-white font-bold rounded p-1'> <i class='bi bi-trash'></i> Delete</button></p></div><div class='text-sm p-1'>"+note.notes+"</div><hr class='my-1'><p class='text-sm text-gray-500'><i>"+note.created_at+"</i></p></div>";
                            
                        
                            notes.append(row);

                           })

                               
                            }
                        })
                     }
                     $(document).ready(function(){
                        //default filter...................................
                        loaddata("all");
                         //click filter......................................
                        $("#find").click(function(){
                            loaddata($("#filter").val());
                        })

                        //live search..............................................................
                        $("#filter").keyup(function(){
                            loaddata($("#filter").val());
                        })
                       
                     })
                     

</script>