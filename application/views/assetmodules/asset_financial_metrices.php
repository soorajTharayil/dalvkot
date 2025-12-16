<div class="content">
    <?php
    function formatIndianCurrency($amount)
    {
        $amount = round($amount); // remove decimals if needed
        $num = (string)$amount;
        $len = strlen($num);
        if ($len > 3) {
            $last3 = substr($num, -3);
            $restUnits = substr($num, 0, $len - 3);
            $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
            return $restUnits . "," . $last3;
        } else {
            return $num;
        }
    }
    ?>

    <?php
    // Fetching asset data
    $this->db->select("*");
    $this->db->from('bf_feedback_asset_creation');
    $this->db->order_by('id', 'ASC');
    $query = $this->db->get();
    $results = $query->result();

    // Initialize financial variables
    $totalAssetValue = 0;
    $netBookValue = 0;
    $ytdDepreciation = 0;
    $newAssetCost = 0;
    $disposedAssetsValue = 0;

    // Calculate metrics
    if (!empty($results)) {
        foreach ($results as $asset) {
            $totalAssetValue += $asset->unitprice;
            $netBookValue += $asset->assetCurrentValue;

            $assetYear = date('Y', strtotime($asset->datet));
            $currentYear = date('Y');

            if ($assetYear == $currentYear) {
                $ytdDepreciation += $asset->deprValue;
            }

            if ($assetYear == $currentYear) {
                $newAssetCost += $asset->unitprice;
            }

            if ($asset->assignstatus == 'Asset Dispose') {
                $disposedAssetsValue += $asset->unitprice;
            }
        }
    ?>

        <!-- Metrics Table -->
        <table cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%; margin-top: 30px; font-family: Arial, sans-serif; font-size: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background-color:rgb(93, 194, 96); color: white; text-align: left;">
                    <th style="padding: 12px; border: 1px solid #ddd;">Financial Metrics</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Value( in Rupees)</th>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color: #f9f9f9;">
                    <td style="padding: 12px; border: 1px solid #ddd;">Total Asset Value (Sum of all asset's purchase cost)</td>
                    <td style="padding: 12px; border: 1px solid #ddd;">₹ <?= formatIndianCurrency($totalAssetValue) ?></td>
                </tr>
                <tr>
                    <td style="padding: 12px; border: 1px solid #ddd;">Current Net Book Value (Value after accumulated depreciation)</td>
                    <td style="padding: 12px; border: 1px solid #ddd;">₹ <?= formatIndianCurrency($netBookValue) ?></td>
                </tr>
                <tr style="background-color: #f9f9f9;">
                    <td style="padding: 12px; border: 1px solid #ddd;">Year-to-Date Depreciation (Total depreciation expense for the current year)</td>
                    <td style="padding: 12px; border: 1px solid #ddd;">₹ <?= formatIndianCurrency($ytdDepreciation) ?></td>
                </tr>
                <tr>
                    <td style="padding: 12px; border: 1px solid #ddd;">Cost of New Assets (Total capital spent on new assets this year)</td>
                    <td style="padding: 12px; border: 1px solid #ddd;">₹ <?= formatIndianCurrency($newAssetCost) ?></td>
                </tr>
                <tr style="background-color: #f9f9f9;">
                    <td style="padding: 12px; border: 1px solid #ddd;">Value of Disposed Assets (Financial impact of disposed assets)</td>
                    <td style="padding: 12px; border: 1px solid #ddd;">₹ <?= formatIndianCurrency($disposedAssetsValue) ?></td>
                </tr>
            </tbody>
        </table>





        <!-- Chart Initialization -->
        <canvas id="financialChart" style="margin-top: 40px;"></canvas>

        <!-- THEN the Chart script -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('financialChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        'Total Asset Value',
                        'Net Book Value',
                        'YTD Depreciation',
                        'Cost of New Assets',
                        'Disposed Assets Value'
                    ],
                    datasets: [{
                        label: 'Amount (₹)',
                        data: [
                            <?= $totalAssetValue ?>,
                            <?= $netBookValue ?>,
                            <?= $ytdDepreciation ?>,
                            <?= $newAssetCost ?>,
                            <?= $disposedAssetsValue ?>
                        ],
                        backgroundColor: [
                            '#4caf50',
                            '#2196f3',
                            '#ff9800',
                            '#9c27b0',
                            '#f44336'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Asset Financial Metrics Overview'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₹' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        </script>


    <?php } else { ?>
        <div class="p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
            No asset data found to calculate financial metrics.
        </div>
    <?php } ?>
</div>