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

<body class="bg-gray-100">
    <div class="container-fluid p-4">
        
        <!-- Header -->
        <div class="bg-yellow-900 rounded-lg text-white p-4 shadow-lg mb-5">
            <h2 class="text-2xl font-bold">Business Reports</h2>
            <p class="text-yellow-100 text-sm">View daily and weekly reports for purchases and sales</p>
        </div>

        <!-- Filter Buttons -->
        <div class="bg-white rounded-xl shadow-md p-4 mb-5">
            <h3 class="font-bold text-yellow-900 text-lg mb-3">Select Time Period</h3>
            <div class="flex flex-wrap gap-2">
                <button onclick="loadReport('today', this)" class="filter-btn bg-yellow-900 hover:bg-yellow-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    Today
                </button>
                <button onclick="loadReport('week', this)" class="filter-btn bg-yellow-900 hover:bg-yellow-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    This Week
                </button>
                <button onclick="loadReport('month', this)" class="filter-btn bg-yellow-900 hover:bg-yellow-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    This Month
                </button>
                <button onclick="loadReport('year', this)" class="filter-btn bg-yellow-900 hover:bg-yellow-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    This Year
                </button>
                <button id="customRangeButton" onclick="toggleCustomDate()" class="filter-btn bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    Custom Range
                </button>
            </div>

            <!-- Custom Date Range -->
            <div id="customDateRange" class="hidden mt-4 flex flex-wrap gap-2 items-center">
                <input type="date" id="fromDate" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <span class="text-gray-600">to</span>
                <input type="date" id="toDate" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <button onclick="loadCustomReport()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    Apply
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-5">
            <div class="bg-green-50 border-l-8 border-green-700 rounded-xl shadow-md p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-600 text-sm">Total Sales</p>
                        <h1 id="totalSales" class="text-sm font-bold text-green-700">0</h1>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-green-700 flex items-center justify-center">
                        <i class="bi bi-currency-dollar text-2xl text-white"></i>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 border-l-8 border-red-700 rounded-xl shadow-md p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-600 text-sm">Total Purchases</p>
                        <h1 id="totalPurchases" class="text-sm font-bold text-red-700">0</h1>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-red-700 flex items-center justify-center">
                        <i class="bi bi-cart text-2xl text-white"></i>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 border-l-8 border-blue-700 rounded-xl shadow-md p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-600 text-sm">Net Profit</p>
                        <h1 id="profit" class="text-sm font-bold text-blue-700">0</h1>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-blue-700 flex items-center justify-center">
                        <i class="bi bi-graph-up text-2xl text-white"></i>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 border-l-8 border-purple-700 rounded-xl shadow-md p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-600 text-sm">Total Transactions</p>
                        <h1 id="transactions" class="text-sm font-bold text-purple-700">0</h1>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-purple-700 flex items-center justify-center">
                        <i class="bi bi-receipt text-xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Report -->
        <div class="bg-white rounded-xl shadow-md p-5 mb-5">
            <h3 class="font-bold text-yellow-900 text-lg mb-4">
                <i class="bi bi-tags"></i> Sales Report
            </h3>
            <div class="table-responsive overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead class="bg-yellow-900 text-white">
                        <tr>
                            <th class="p-3 text-left">#</th>
                            <th class="p-3 text-left">Date</th>
                            <th class="p-3 text-left">Customer</th>
                            <th class="p-3 text-right">Amount (RWF)</th>
                            <th class="p-3 text-right">Discount (RWF)</th>
                            <th class="p-3 text-right">Net Total (RWF)</th>
                        </tr>
                    </thead>
                    <tbody id="salesTable">
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">Loading sales data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-right">
                <strong class="text-lg">Total Sales: </strong>
                <span id="salesTotal" class="text-green-700 font-bold text-xl">0 RWF</span>
            </div>
        </div>

        <!-- Purchases Report -->
        <div class="bg-white rounded-xl shadow-md p-5">
            <h3 class="font-bold text-yellow-900 text-lg mb-4">
                <i class="bi bi-cart"></i> Purchases Report
            </h3>
            <div class="table-responsive overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead class="bg-yellow-900 text-white">
                        <tr>
                            <th class="p-3 text-left">#</th>
                            <th class="p-3 text-left">Date</th>
                            <th class="p-3 text-left">Supplier</th>
                            <th class="p-3 text-right">Amount (RWF)</th>
                        </tr>
                    </thead>
                    <tbody id="purchasesTable">
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">Loading purchases data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-right">
                <strong class="text-lg">Total Purchases: </strong>
                <span id="purchasesTotal" class="text-red-700 font-bold text-xl">0 RWF</span>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const reportDataUrl = './apis/reportdata.php';

        function toggleCustomDate() {
            $('#customDateRange').toggleClass('hidden');
        }

        function setActiveButton(buttonElement) {
            $('.filter-btn').removeClass('bg-green-700').addClass('bg-yellow-900');
            $(buttonElement).removeClass('bg-yellow-900').addClass('bg-green-700');
        }

        function loadReport(filter, buttonElement) {
            setActiveButton(buttonElement);

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

            const sales = Array.isArray(response.sales) ? response.sales : [];
            const purchases = Array.isArray(response.purchases) ? response.purchases : [];

            $('#totalSales').text(formatCurrency(response.total_sales));
            $('#totalPurchases').text(formatCurrency(response.total_purchases));
            $('#profit').text(formatCurrency(response.profit));
            $('#transactions').text(response.transactions);

            let salesHTML = '';
            let salesTotal = 0;
            if (sales.length > 0) {
                sales.forEach((sale, index) => {
                    const netTotal = parseFloat(sale.net.replace(/,/g, ''));
                    salesTotal += isNaN(netTotal) ? 0 : netTotal;
                    salesHTML += `
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">${index + 1}</td>
                            <td class="p-3">${formatDate(sale.date)}</td>
                            <td class="p-3">${sale.customer}</td>
                            <td class="p-3 text-right">${formatCurrency(sale.amount)}</td>
                            <td class="p-3 text-right">${formatCurrency(sale.discount)}</td>
                            <td class="p-3 text-right font-bold text-green-700">${formatCurrency(sale.net)}</td>
                        </tr>
                    `;
                });
            } else {
                salesHTML = '<tr><td colspan="6" class="p-4 text-center text-gray-500">No sales found for this period</td></tr>';
            }
            $('#salesTable').html(salesHTML);
            $('#salesTotal').text(formatCurrency(salesTotal.toFixed(2)));

            let purchasesHTML = '';
            let purchasesTotal = 0;
            if (purchases.length > 0) {
                purchases.forEach((purchase, index) => {
                    const amount = parseFloat(purchase.total.replace(/,/g, ''));
                    purchasesTotal += isNaN(amount) ? 0 : amount;
                    purchasesHTML += `
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">${index + 1}</td>
                            <td class="p-3">${formatDate(purchase.date)}</td>
                            <td class="p-3">${purchase.supplier}</td>
                            <td class="p-3 text-right font-bold text-red-700">${formatCurrency(purchase.total)}</td>
                        </tr>
                    `;
                });
            } else {
                purchasesHTML = '<tr><td colspan="4" class="p-4 text-center text-gray-500">No purchases found for this period</td></tr>';
            }
            $('#purchasesTable').html(purchasesHTML);
            $('#purchasesTotal').text(formatCurrency(purchasesTotal.toFixed(2)));
        }

        function formatCurrency(amount) {
            const value = parseFloat(amount);
            if (Number.isNaN(value)) {
                return '0.00 RWF';
            }
            return value.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' RWF';
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            if (Number.isNaN(date.getTime())) {
                return dateString;
            }
            return date.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        $(document).ready(function() {
            loadReport('today', $('.filter-btn').first()[0]);
        });
    </script>
</body>
</html>