<?php
include("connection.php");
$noteid=$_GET['note'];
$business=$_SESSION['user'];
$selectnotes=$conn->prepare("SELECT * FROM notes where note_id=? and business=?");
$selectnotes->bind_param("ii",$noteid,$business);
$selectnotes->execute();
$notesresult=$selectnotes->get_result();
$noterow=$notesresult->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<div class="flex flex-wrap gap-2 p-2 border rounded mb-2 justify-between px-2">

    <!-- Bold -->
    <button type="button" onclick="format('bold')"><b>B</b></button>

    <!-- Italic -->
    <button type="button" onclick="format('italic')"><i>I</i></button>

    <!-- Underline -->
    <button type="button" onclick="format('underline')"><u>U</u></button>

    <!-- Font Size -->
    <select onchange="changeSize(this.value)">
        <option value="">Size</option>
        <option value="1">8px</option>
        <option value="2">10px</option>
        <option value="3">12px</option>
        <option value="4">14px</option>
        <option value="5">18px</option>
        <option value="6">24px</option>
        <option value="7">32px</option>
    </select>

    <!-- Align -->
    <button onclick="format('justifyLeft')" type="button">Left</button>
    <button onclick="format('justifyCenter')" type="button">Center</button>
    <button onclick="format('justifyRight')" type="button">Right</button>
    <!-- Or use a color picker -->
    <input type="color" onchange="setColor(this.value)">
    <button type="button" class="bg-green-500 text-sm text-white font-bold border-green-500 shadow shadow-green-500 border hover:bg-green-400 rounded p-1 " id="save"> <i class="bi bi-check-circle"></i> Save</button>

</div>
<div class="title w-full p-2 border bg-gray-100 font-bold text-sm">
    <label for="">Title</label>
    <input type="text" name="" value="<?= htmlspecialchars($noterow['title']) ?>" id="title" class="p-1 w-[80%] rounded">

</div>

<div id="editor"
     contenteditable="true"
     class="border rounded p-4 min-h-[300px] outline-yellow-600">
     <?php echo $noterow['notes'] ?>
</div>
<script>

    function format(command)
{
    document.execCommand(command, false, null);
}

function changeSize(size)
{
    document.execCommand("fontSize", false, size);
}

function setColor(color)
{
    document.execCommand("foreColor", false, color);
}

$("#save").click(function(){
    var notes = document.getElementById("editor").innerHTML;
  
    $.ajax({
        url:"./apis/editnotes.php",
        type:"POST",
        dataType:"json",
        data:{note:notes,title:$("#title").val(),noteid:'<?= $noteid ?>'},
        success:function(data){
            alert(data);
            window.location='notes';
        }
    })
})


</script>

</body>
</html>