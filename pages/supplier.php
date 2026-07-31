
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier</title>
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
</head>

<body>
    <div class="container-fluid h-[100%]">
        <div class="flex w-full p-2 bg-yellow-900 justify-between h-[8%]"><h1 class="text-white font-bold text-sm p-1 hidden md:block"><i class="bi bi-people"></i> Supplier List</h1>
            <div class="search bg-white p-1 w-[60%] md:w-1/2 rounded flex"><input type="text" name="search" placeholder="search supplier" class="w-[80%] outline-none text-sm" id="filter"><button type="button" class="w-[20%] bg-gray-200 outline-none flex justify-center" id="find"> <i class="bi bi-search"></i> <span class="hidden md:block p-0 px-1 m-0 w-[fit-content]">Search</span></button></div>
             <a href="add_supplier" class="font-bold text-white p-1 border border-2 border-blue-500 bg-blue-500/30 hover:bg-blue-500 shadow shadow-blue rounded text-sm"> <i class="bi bi-plus-circle"></i> Add Supplier</a></div>
        <div class="table-responsive w-full overflow-y-auto my-2 h-[92%]">
            <table class="w-full border-collapse [&_td]:p-2 text-sm font-bold [&_th]:text-left [&_th]:p-2">
                <thead class="bg-yellow-900 text-white text-sm"><tr>
                    <th>#</th>
                    <th class="">Supplier Name</th>
                    <th>Supplier Phone</th>
                    <th class="hidden md:block">Location</th>
                    <th>View</th>

                </tr></thead>
                <tbody id="customer-list">
                    <script>

                     function loaddata(filter){

                        $.ajax({
                            url:'./apis/supplier.php',
                            type:'post',
                            dataType:'json',
                            data:{filter:filter},
                            success:function(data){
                                var customers=$("#customer-list");
                                customers.empty();
                           $.each(data,function(index,customer){
                          var row="<tr class='border hover:bg-gray-200'><td>"+(index+1)+"</td><td>"+customer.name+"</td><td>"+customer.phone+"</td><td class='hidden md:block'>"+customer.location+"</td><td><a href='viewsupplier?id="+customer.sp_id+"' class='text-white  font-bold bg-blue-500 rounded p-1 px-2 text-sm'><i class='bi bi-eye'></i></a></td> </tr>";
                          customers.append(row);

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