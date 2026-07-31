
<?php

if (! isset($_SESSION['customer'])) {
   echo"<script>alert('Please Choose Customer First'),location='add_sale'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Management</title>
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
</head>

<body>
    <div class="container-fluid h-[100%]">
        <div class="flex w-full p-2 bg-yellow-900 justify-between h-[8%]"><h1 class="text-white font-bold text-sm p-1 hidden md:block"><i class="bi bi-box"></i> Get Item</h1>
            <div class="search bg-white p-1 w-[70%] md:w-1/2 rounded flex"><input type="text" name="search" placeholder="search Item" class="w-[80%] outline-none text-sm" id="filter"><button type="button" class="w-[20%] bg-gray-200 outline-none flex justify-center" id="find"> <i class="bi bi-search"></i> <span class="hidden md:block p-0 px-1 m-0 w-[fit-content]">Search</span></button></div>
             <a href="add_item" class="font-bold text-white p-2 md:p-1 border border-2 border-yellow-500 bg-yellow-500/30 hover:bg-yellow-500 shadow shadow-yellow rounded text-sm"> <i class="bi bi-plus-circle"></i> Add Item</a></div>
        <div class="table-responsive w-full overflow-y-auto my-2 h-[92%]">
            <table class="w-full border-collapse [&_td]:p-2 text-sm [&_th]:text-left [&_th]:p-2">
                <thead class="bg-yellow-900 text-white text-sm"><tr>
                    <th>#</th>
                    <th class="">Name</th>
                    <th>Stock</th>
                    <th class="hidden md:block">In Price</th>
                    <th class=""><span class=" md:hidden">Price</span><span class="hidden md:block">Out Price</span></th>
                    <th>Get</th>

                </tr></thead>
                <tbody id="item-list">
                    <script>

                     function loaddata(filter){

                        $.ajax({
                            url:'./apis/item.php',
                            type:'post',
                            dataType:'json',
                            data:{filter:filter},
                            success:function(data){
                                var items=$("#item-list");
                                items.empty();
                           $.each(data,function(index,item){
                          var row="<tr class='border hover:bg-gray-200'><td>"+(index+1)+"</td><td>"+item.item_name+"</td><td>"+item.quantity+"</td><td class='hidden md:block'>"+Number(item.in_price).toLocaleString()+"</td><td>"+Number(item.out_price).toLocaleString()+"</td><td><a href='sale_quantity?product="+item.id+"' class='text-white bg-yellow-400  font-bold rounded p-1 px-2 text-sm'><i class='bi bi-check'></i></a></td> </tr>";
                          items.append(row);

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
                    
                        
                            
                       
                        
                  
                </tbody>
            </table>
        </div>

       
    </div>

</body>

</html>