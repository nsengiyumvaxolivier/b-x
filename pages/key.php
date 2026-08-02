<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Key</title>
</head>
<body>
    <div class="container-fluid h-[100%] flex justify-center items-center p-2">
        <div class="container m-auto w-full md:w-[40%] p-2 bg-yellow-800 shadow shadow-gray-500 rounded">
            <div class="flex justify-between my-2"><h1 class="text-sm font-bold text-white">Authorization Form</h1> <p class="text-white p-1 rounded text-white bg-red-500 w-['fit-content'] hidden" id="message"></p></div>
            
            <hr class="my-2">
            <label for="key" class="text-white block my-2 font-bold text-sm">Key:</label>
            <input type="password" id="key" placeholder="Enter Key" class="w-full outline rounded outline-yellow-500 font-bold text-sm p-2">
            <div class="flex my-2 p-2 justify-end"><button id="submit-key" class="bg-yellow-600 text-white font-bold text-sm rounded p-2 hover:bg-yellow-500" type="button" onclick="checkkey()">Get In</button></div>
            
        </div>
    </div>
</body>
</html>
<script>
function checkkey(){
    var key=document.getElementById("key").value;
   $.ajax({
    url:'./apis/selectkey.php',
    type:'post',
    dataType:'json',
    data:{key:key},
    success:function(data){
        if(data=="authorized"){
            window.location.href="stock";
        }
        else{
           $("#message").removeClass("hidden");
           $("#message").animate({opacity:1},1000);
           $("#message").animate({opacity:0},2000);
           $("#message").text("Invalid Key");
        }
    }
   })
}
</script>