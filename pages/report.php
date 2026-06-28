<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

include __DIR__ . '/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
</head>

<body class="">
    <div class="bg-yellow-900 shadow-md p-4 mb-5">
        <h3 class="font-bold text-white text-lg">Report</h3>
        <hr>

        <div class="flex flex-wrap gap-2 p-2">
            <button onclick="loadReport('today', this)" class="filter-btn text-sm bg-yellow-900 shadow border border-white shadow-white hover:bg-[#6b4f3f] text-white px-4 py-2 rounded-lg text-sm font-semibold">
                Today
            </button>
            <button onclick="loadReport('week', this)" class="filter-btn text-sm bg-yellow-900 shadow border border-white shadow-white hover:bg-[#6b4f3f] text-white px-4 py-2 rounded-lg text-sm font-semibold">
                Week
            </button>
            <button onclick="loadReport('month', this)" class="filter-btn text-sm bg-yellow-900 shadow border border-white shadow-white hover:bg-[#6b4f3f] text-white px-4 py-2 rounded-lg text-sm font-semibold">
                Month
            </button>
            <button onclick="loadReport('year', this)" class="filter-btn text-sm bg-yellow-900 shadow border border-white shadow-white hover:bg-[#6b4f3f] text-white px-4 py-2 rounded-lg text-sm font-semibold">
                Year
            </button>
            <button id="customRangeButton" onclick="toggleCustomDate()" class="filter-btn text-sm bg-yellow-900 shadow border border-white shadow-white hover:bg-[#3f2f1f] text-white px-4 py-2 rounded-lg text-sm font-semibold">
                Range
            </button>
        </div>

        <div id="customDateRange" class="hidden mt-4 flex flex-wrap gap-2 items-center">
            <input type="date" id="fromDate" class="border border-[#b49d84] rounded-lg px-3 py-2 text-sm">
            <span class="text-[#5f4731]">to</span>
            <input type="date" id="toDate" class="border border-[#b49d84] rounded-lg px-3 py-2 text-sm">
            <button onclick="loadCustomReport()" class="bg-[#3f2f1f] hover:bg-[#2f2218] text-white px-4 py-2 rounded-lg text-sm font-semibold">
                Apply
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-5 p-2">
        <div class="bg-[#f7efe3] border-l-8 border-[#8a5f3d] rounded-xl shadow-md p-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-[#5f4731] text-sm">Total Sales</p>
                    <h1 id="totalSales" class="text-3xl font-bold text-[#8a5f3d]">0</h1>
                </div>
                <div class="w-14 h-14 rounded-full bg-[#8a5f3d] flex items-center justify-center">
                    <i class="bi bi-tags text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-[#f7efe3] border-l-8 border-[#9c4a32] rounded-xl shadow-md p-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-[#5f4731] text-sm">Total Purchases</p>
                    <h1 id="totalPurchases" class="text-3xl font-bold text-[#9c4a32]">0</h1>
                </div>
                <div class="w-14 h-14 rounded-full bg-[#9c4a32] flex items-center justify-center">
                    <i class="bi bi-cart text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-[#f7efe3] border-l-8 border-[#4f2f1f] rounded-xl shadow-md p-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-[#5f4731] text-sm">Total Debit</p>
                    <h1 id="totalDebit" class="text-3xl font-bold text-[#4f2f1f]">0 RWF</h1>
                </div>
                <div class="w-14 h-14 rounded-full bg-[#4f2f1f] flex items-center justify-center">
                    <i class="bi bi-currency-dollar text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-[#f7efe3] border-l-8 border-[#70512f] rounded-xl shadow-md p-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-[#5f4731] text-sm">Items Sold</p>
                    <h1 id="itemsSold" class="text-3xl font-bold text-[#70512f]">0</h1>
                </div>
                <div class="w-14 h-14 rounded-full bg-[#70512f] flex items-center justify-center">
                    <i class="bi bi-box-seam text-2xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

<div class="flex justify-end mb-5">
     <button onclick="downloadPdf('salesReportSection', 'sales-report')" class="bg-green-500 shadow border border-white shadow-white hover:bg-[#6b4f3f] text-white px-4 py-2 rounded-lg text-sm font-semibold">
                Download Sales PDF
            </button>
</div>
    <div class="border shadow-md p-2 mb-5" id="salesReportSection">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            <div>
                <h3 class="font-bold text-green-500 text-lg mb-1">
                    <i class="bi bi-tags"></i> Sales report
                </h3>
                <p class="text-[#5f4731] text-sm" id="salesRangeLabel">Range: Today</p>
            </div>
           
        </div>
        <div class="table-responsive overflow-x-auto">
            <table class="w-full border-collapse text-sm [&_th]:text-left [&_td]:text-left">
                <thead class="bg-yellow-900 text-white">
                    <tr>
                        <th class="p-2 text-left">#</th>
                        <th class="p-2 text-left">Item</th>
                        <th class="p-2 text-right">Quantity</th>
                        <th class="p-2 text-right">Total Dsc</th>
                        <th class="p-2 text-right">Total Price</th>
                       
                        <th class="p-2 text-right">Left Stock</th>
                    </tr>
                </thead>
                <tbody id="salesTable">
                    <tr>
                        <td colspan="7" class="p-4 text-center text-[#5f4731]">Loading sales data...</td>
                    </tr>
                </tbody>
                <tfoot id="salesFooter"></tfoot>
            </table>
        </div>
    </div>
    <div class="flex justify-end mb-5"> <button onclick="downloadPdf('purchaseReportSection', 'purchase-report')" class="bg-blue-500 shadow border border-white shadow-white hover:bg-[#6b4f3f] text-white px-4 py-2 rounded-lg text-sm font-semibold">
                Download Purchase PDF
            </button></div>

    <div class="border shadow-md p-2" id="purchaseReportSection">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            <div>
                <h3 class="font-bold text-blue-500 text-lg mb-1">
                    <i class="bi bi-cart"></i> Purchases report
                </h3>
                <p class="text-[#5f4731] text-sm" id="purchaseRangeLabel">Range: Today</p>
            </div>
          
        </div>
        <div class="table-responsive overflow-x-auto">
            <table class="w-full border-collapse text-sm [&_th]:text-left [&_th]:p-2 [&_td]:text-left">
                <thead class="bg-yellow-900 text-white">
                    <tr>
                        <th class="p-3 text-left">#</th>
                        <th class="p-3 text-left">Item</th>
                        <th class="p-3 text-right">Quantity</th>
                        <th class="p-3 text-right">Total Cost</th>
                        <th class="p-3 text-right">Current Stock</th>
                    </tr>
                </thead>
                <tbody id="purchasesTable">
                    <tr>
                        <td colspan="5" class="p-4 text-center text-[#5f4731]">Loading purchase data...</td>
                    </tr>
                </tbody>
                <tfoot id="purchasesFooter"></tfoot>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../plugins/js/html2pdf.bundle.min.js"></script>
    <script>
        const reportDataUrl = './apis/reportdata.php';
        let currentRangeLabel = 'Today';

        function toggleCustomDate() {
            $('#customDateRange').toggleClass('hidden');
        }

        function setActiveButton(buttonElement) {
            $('.filter-btn').removeClass('bg-[#3f2f1f]').addClass('bg-[#7a5a3e]');
            $(buttonElement).removeClass('bg-[#7a5a3e]').addClass('bg-[#3f2f1f]');
        }

        function updateRangeLabels(label) {
            currentRangeLabel = label;
            $('#salesRangeLabel').text(`Range: ${label}`);
            $('#purchaseRangeLabel').text(`Range: ${label}`);
        }

        function loadReport(filter, buttonElement) {
            setActiveButton(buttonElement);
            const label = filter === 'today' ? 'Today'
                : filter === 'week' ? 'Week'
                : filter === 'month' ? 'Month'
                : filter === 'year' ? 'Year'
                : 'Custom Range';

            updateRangeLabels(label);

            $.ajax({
                url: reportDataUrl,
                type: 'POST',
                dataType: 'json',
                data: { filter: filter },
                success: function(data) {
                    displayReport(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    console.error('Response:', xhr.responseText);
                    alert('Error loading report data. Please check console for details.');
                }
            });
        }

        function loadCustomReport() {
            const from = $('#fromDate').val();
            const to = $('#toDate').val();

            if (!from || !to) {
                alert('Please select both from and to dates');
                return;
            }

            const label = `Custom Range: ${from} to ${to}`;
            updateRangeLabels(label);
            setActiveButton($('#customRangeButton')[0]);

            $.ajax({
                url: reportDataUrl,
                type: 'POST',
                dataType: 'json',
                data: { filter: 'custom', from: from, to: to },
                success: function(data) {
                    displayReport(data);
                },
                error: function(xhr, status, error) {
                    console.error('Custom report error:', error);
                    console.error('Response:', xhr.responseText);
                    alert('Error loading custom report data. Please check console for details.');
                }
            });
        }

        function displayReport(data) {
            const response = (typeof data === 'string') ? JSON.parse(data) : data;

            if (response.error) {
                alert('Report error: ' + response.error);
                return;
            }

            $('#totalSales').text(formatNumber(response.total_sales_count));
            $('#totalPurchases').text(formatNumber(response.total_purchases_count));
            $('#totalDebit').text(`${formatAmount(response.total_debit)} RWF`);
            $('#itemsSold').text(formatNumber(response.total_items_sold));

            let salesHTML = '';
            let salesQtyTotal = 0;
            let salesDiscountTotal = 0;
            let salesPriceTotal = 0;
            let salesOutTotal = 0;

            if (Array.isArray(response.sales_by_item) && response.sales_by_item.length > 0) {
                response.sales_by_item.forEach((item, index) => {
                    salesQtyTotal += Number(item.quantity_sold) || 0;
                    salesDiscountTotal += Number(item.total_discount) || 0;
                    salesPriceTotal += Number(item.total_amount) || 0;
                    salesOutTotal += Number(item.total_out_price) || 0;

                    salesHTML += `
                        <tr class="border-b hover:bg-[#f7efe3]">
                            <td class="p-1">${index + 1}</td>
                            <td class="p-1">${item.item_name}</td>
                            <td class="p-1 text-right">${formatNumber(item.quantity_sold)}</td>
                            <td class="p-1 text-right">${formatAmount(item.total_discount)}</td>
                            <td class="p-1 text-right">${formatAmount(item.total_amount)}</td>
                           
                            <td class="p-1 text-right">${formatNumber(item.left_stock)}</td>
                        </tr>
                    `;
                });
            } else {
                salesHTML = '<tr><td colspan="7" class="p-4 text-center text-[#5f4731]">No sales found for this period</td></tr>';
            }

            $('#salesTable').html(salesHTML);
            $('#salesFooter').html(`
                <tr class="font-bold border-t-2">
                    <td class="p-3">Total</td>
                    <td class="p-3"></td>
                    <td class="p-3 text-right">${formatNumber(salesQtyTotal)}</td>
                    <td class="p-3 text-right">${formatAmount(salesDiscountTotal)}</td>
                    <td class="p-3 text-right">${formatAmount(salesPriceTotal)}</td>
                  
                    <td class="p-3"></td>
                </tr>
            `);

            let purchaseHTML = '';
            let purchaseQtyTotal = 0;
            let purchaseInTotal = 0;

            if (Array.isArray(response.purchase_by_item) && response.purchase_by_item.length > 0) {
                response.purchase_by_item.forEach((item, index) => {
                    purchaseQtyTotal += Number(item.quantity_purchased) || 0;
                    purchaseInTotal += Number(item.total_in_cost) || 0;

                    purchaseHTML += `
                        <tr class="border-b hover:bg-[#f7efe3]">
                            <td class="p-1">${index + 1}</td>
                            <td class="p-1">${item.item_name}</td>
                            <td class="p-1 text-right">${formatNumber(item.quantity_purchased)}</td>
                            <td class="p-1 text-right">${formatAmount(item.total_in_cost)}</td>
                            <td class="p-1 text-right">${formatNumber(item.left_stock)}</td>
                        </tr>
                    `;
                });
            } else {
                purchaseHTML = '<tr><td colspan="5" class="p-4 text-center text-[#5f4731]">No purchases found for this period</td></tr>';
            }

            $('#purchasesTable').html(purchaseHTML);
            $('#purchasesFooter').html(`
                <tr class="font-bold border-t-2">
                    <td class="p-3">Totals</td>
                    <td class="p-3"></td>
                    <td class="p-3 text-right">${formatNumber(purchaseQtyTotal)}</td>
                    <td class="p-3 text-right">${formatAmount(purchaseInTotal)}</td>
                    <td class="p-3"></td>
                </tr>
            `);
        }

        function downloadPdf(sectionId, fileName) {
            const element = document.getElementById(sectionId);
            const opt = {
                margin: 0.2,
                filename: `${fileName}.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 5 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
            };
            html2pdf().set(opt).from(element).save();
        }

        function formatNumber(value) {
            return Number(value || 0).toLocaleString('en-US');
        }

        function formatAmount(value) {
            return Number(value || 0).toLocaleString();
        }

        $(document).ready(function() {
            loadReport('today', $('.filter-btn').first()[0]);
        });
    </script>
</body>
</html>