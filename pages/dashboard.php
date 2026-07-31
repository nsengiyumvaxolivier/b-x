<?php 
$business=$_SESSION['user'];
?>
<div class="w-full">

    <!-- Header -->
    <div class="bg-yellow-900 rounded-lg text-white p-4 shadow-lg">
        <h2 class="text-2xl font-bold">
            <?php echo htmlspecialchars($_SESSION['business']); ?>
        </h2>

        <p class="text-yellow-100 text-sm">
            Welcome back. Manage your business from one place.
        </p>
    </div>


    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mt-5">

        <!-- Pending Sales -->
        <div class="bg-amber-50 border-l-8 border-yellow-900 rounded-xl shadow-md p-4">

            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-600 text-sm">Pending Sales</p>

                    <h1 id="sales" class="text-4xl font-bold text-yellow-900">
                        0
                    </h1>
                </div>

                <div class="w-14 h-14 rounded-full bg-yellow-900 flex items-center justify-center">
                    <i class="bi bi-tags text-2xl text-white"></i>
                </div>
            </div>

            <a href="pendingsales" class="text-yellow-900 font-semibold text-sm mt-4 inline-block">
                View →
            </a>

        </div>



        <!-- Pending Purchase -->
        <div class="bg-yellow-100 border-l-8 border-yellow-800 rounded-xl shadow-md p-4">

            <div class="flex justify-between items-center">
                <div>

                    <p class="text-gray-600 text-sm">
                        Pending Purchases
                    </p>

                    <h1 id="purchase" class="text-4xl font-bold text-yellow-800">
                        0
                    </h1>

                </div>

                <div class="w-14 h-14 rounded-full bg-yellow-800 flex items-center justify-center">
                    <i class="bi bi-cart text-2xl text-white"></i>
                </div>
            </div>

            <a href="purchase" class="text-yellow-900 font-semibold text-sm mt-4 inline-block">
                View →
            </a>

        </div>



        <!-- Expired -->
        <div class="bg-orange-50 border-l-8 border-orange-800 rounded-xl shadow-md p-4">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-600 text-sm">
                        Expired Products
                    </p>

                    <h1 id="expired" class="text-4xl font-bold text-orange-800">
                        0
                    </h1>

                </div>

                <div class="w-14 h-14 rounded-full bg-orange-800 flex items-center justify-center">

                    <i class="bi bi-exclamation-triangle text-2xl text-white"></i>

                </div>

            </div>

            <a href="expireditems" class="text-orange-800 font-semibold text-sm mt-4 inline-block">
                View →
            </a>

        </div>



        <!-- Notifications -->
        <div class="bg-stone-100 border-l-8 border-stone-700 rounded-xl shadow-md p-4">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-600 text-sm">
                        Notifications
                    </p>

                    <h1 id="notification" class="text-4xl font-bold text-stone-700">
                        0
                    </h1>

                </div>

                <div class="w-14 h-14 rounded-full bg-stone-700 flex items-center justify-center">

                    <i class="bi bi-bell text-2xl text-white"></i>

                </div>

            </div>

            <a href="#" class="text-stone-700 font-semibold text-sm mt-4 inline-block">
                View →
            </a>

        </div>

    </div>



    <!-- Second Row -->

    <div class="grid lg:grid-cols-2 gap-5 mt-6">

        <!-- Quick Actions -->

        <div class="bg-white rounded-xl shadow-md p-5">

            <h3 class="font-bold text-yellow-900 text-lg mb-4">
                Quick Actions
            </h3>

            <div class="grid grid-cols-2 gap-3">

                <a href="sales"
                    class="bg-yellow-900 hover:bg-yellow-800 text-white rounded-lg p-3 text-center">

                    <i class="bi bi-tags"></i><br>

                    Sales

                </a>

                <a href="purchase"
                    class="bg-yellow-900 hover:bg-yellow-800 text-white rounded-lg p-3 text-center">

                    <i class="bi bi-cart"></i><br>

                    Purchase

                </a>

                <a href="item"
                    class="bg-yellow-900 hover:bg-yellow-800 text-white rounded-lg p-3 text-center">

                    <i class="bi bi-box-seam"></i><br>

                    Product

                </a>

                <a href="customer"
                    class="bg-yellow-900 hover:bg-yellow-800 text-white rounded-lg p-3 text-center">

                    <i class="bi bi-people"></i><br>

                    Customer

                </a>

            </div>

        </div>



        <!-- Recent Activity -->

        <div class=" rounded-xl shadow-md p-5">
            <h1 class="text-yellow-800 font-bold text-xl my-3">Business Share 
                <button id="download" class="text-sm bg-blue-500 text-white rounded p-2">Download Code</button>
            </h1>
            <p id="qr"></p>

            

            

        </div>

    </div>

</div>



<script>
    var url = "http://localhost/busines/customer/business?business=<?php echo $business ?>";
new QRCode(document.getElementById("qr"), {
    text: url,
    width: 150,
    height: 150,
    colorDark:"black",
    colorLight:"white"
   
    
});
//download code....................................................
var button = document.getElementById("download");
 button.addEventListener("click",function () {  
        var text=document.getElementById("qr");
      
        var opt={
            margin:0.2,
            with:100,
            filename:"<?php echo $_SESSION['business'] ?>",
            image: {type:'jpeg',quality: 0.8},
            html2canvas:{scale: 5},
            jsPDF:{unit: 'in', format: 'A5', orientation: 'portrait'}
        };
        html2pdf(text,opt);
    });



function loadDashboard(){

    $.ajax({
        url:"./apis/allsales.php",
        success:function(data){

            $("#sales").html(data);

        }
    });
     $.ajax({
        url:"./apis/expireditems.php",
        success:function(data){

            $("#expired").html(data);

        }
    });

}

loadDashboard();

setInterval(loadDashboard,5000);

</script>