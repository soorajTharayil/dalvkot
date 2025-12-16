<div class="content">
    <?php
    // Fetch hospital logo
    $this->db->select('logo');
    $this->db->from('setting');

    $this->db->limit(1);
    $hospital = $this->db->get()->row();
    $hospitalLogo = '';
    if (!empty($hospital)) {
        $hospitalLogo = base_url('uploads/' . $hospital->logo);
    }

    // print_r($hospital);
    // exit;
    ?>

    <?php
    $this->db->select("patientid, assetname, qr_code_image");
    $this->db->from('bf_feedback_asset_creation');
    $this->db->order_by('id', 'ASC');
    $query = $this->db->get();
    $results  = $query->result();
    ?>

    <?php if (!empty($results)) { ?>
        <button id="printBtn" style="background:#2E86C1;color:white;padding:10px 24px;font-size:17px;border:none;border-radius:6px;cursor:pointer;margin:20px 0;box-shadow:0 2px 4px rgba(0,0,0,0.1);">
            🖨️ Print
        </button>

        <table class="qr-table">
            <?php for ($i = 0; $i < count($results); $i += 3) : ?>
                <tr>
                    <!-- First QR -->
                    <td class="asset-container" style="margin-right: 10px; margin-bottom:7px;">
                        <?php
                        $patientId = $results[$i]->patientid;
                        $assetName = $results[$i]->assetname;

                        // Break into chunks every 25 characters for patient ID
                        $pidChunks = str_split($patientId, 25);
                        $wrappedId = implode("<br>", $pidChunks);

                        // Remove asset name display
                        $displayText = $wrappedId; // only show patient ID, no asset name
                        ?>
                        <div class="asset-info">
                            <?php if (!empty($hospitalLogo)) : ?>
                                <img class="hospital-logo" src="<?php echo $hospitalLogo; ?>" alt="Hospital Logo">
                            <?php endif; ?>
                            <span class="asset-text"><?php echo $displayText; ?></span>
                        </div>

                        <?php if (!empty($results[$i]->qr_code_image)) : ?>
                            <img class="qr-image" src="<?php echo $results[$i]->qr_code_image; ?>" alt="QR Code">
                        <?php endif; ?>
                    </td>


                    <!-- Second QR -->
                    <td class="asset-container" style="margin-right: 10px; margin-bottom:7px;">
                        <?php
                        if (!empty($results[$i + 1])) {
                            $patientId = $results[$i + 1]->patientid;
                            $assetName = $results[$i + 1]->assetname;

                            // Break into chunks every 25 characters for patient ID
                            $pidChunks = str_split($patientId, 25);
                            $wrappedId = implode("<br>", $pidChunks);

                            // Remove asset name display
                            $displayText = $wrappedId; // only show patient ID, no asset name
                        ?>
                            <div class="asset-info">
                                <?php if (!empty($hospitalLogo)) : ?>
                                    <img class="hospital-logo" src="<?php echo $hospitalLogo; ?>" alt="Hospital Logo">
                                <?php endif; ?>
                                <span class="asset-text"><?php echo $displayText; ?></span>
                            </div>

                            <?php if (!empty($results[$i + 1]->qr_code_image)) : ?>
                                <img class="qr-image" src="<?php echo $results[$i + 1]->qr_code_image; ?>" alt="QR Code">
                            <?php endif; ?>
                        <?php } ?>
                    </td>

                    <!-- Third QR -->
                    <td class="asset-container" style="margin-bottom:7px;">
                        <?php
                        if (!empty($results[$i + 2])) {
                            $patientId = $results[$i + 2]->patientid;
                            $assetName = $results[$i + 2]->assetname;

                            // Break into chunks every 25 characters for patient ID
                            $pidChunks = str_split($patientId, 25);
                            $wrappedId = implode("<br>", $pidChunks);

                            // Remove asset name display
                            $displayText = $wrappedId; // only show patient ID, no asset name
                        ?>
                            <div class="asset-info">
                                <?php if (!empty($hospitalLogo)) : ?>
                                    <img class="hospital-logo" src="<?php echo $hospitalLogo; ?>" alt="Hospital Logo">
                                <?php endif; ?>
                                <span class="asset-text"><?php echo $displayText; ?></span>
                            </div>

                            <?php if (!empty($results[$i + 2]->qr_code_image)) : ?>
                                <img class="qr-image" src="<?php echo $results[$i + 2]->qr_code_image; ?>" alt="QR Code">
                            <?php endif; ?>
                        <?php } ?>
                    </td>


                </tr>
            <?php endfor; ?>

        </table>
    <?php } ?>
</div>


<style>
    .hospital-logo {
        width: 70px;
        height: auto;
        object-fit: contain;
        margin-bottom: 4px;
        display: block;
    }

    .asset-container {
        margin-right: 20px;
        padding-right: 8px;
    }


    .qr-table {
        width: 100%;
        border-collapse: collapse;
    }

    .qr-table tr {
        display: flex;
        width: 100%;
    }

    .qr-table td {
        flex: 1;
        box-sizing: border-box;
        padding: 10px;
        margin: 5px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #f9f9f9;
        display: flex;
        flex-direction: row;
        /* Change to row for horizontal layout */
        align-items: center;
        justify-content: space-between;
        /* Space between left and right */
        gap: 10px;
        /* Gap between left and right */
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    .asset-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .asset-text {
        font-size: 13px;
        font-weight: 600;
        text-align: left;
        word-break: break-word;
        white-space: normal;
        color: #333;
    }

    .qr-image {
        width: 60px;
        height: 60px;
        object-fit: contain;
        margin-left: auto;
    }

    .selected {
        background-color: rgb(217, 223, 230) !important;
        border: 2px solid rgb(150, 160, 170) !important;
    }

    /* Print Styles */
    @media print {
        #printBtn {
            display: none;
        }

        .asset-container {
            margin-right: 15px;
        }

        .qr-table {
            width: 100%;
            border-collapse: collapse;
        }

        .qr-table tr {
            display: flex;
            width: 100%;
            page-break-inside: avoid;
        }

        .qr-table td {
            flex: 1;
            box-sizing: border-box;
            padding: 5px;
            margin: 2px;
            border: 1px solid #000;
            display: flex;
            flex-direction: row;
            /* Keep horizontal layout for printing too */
            align-items: center;
            justify-content: space-between;
            gap: 4px;
            background: #fff !important;
            box-shadow: none !important;
        }

        .asset-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .asset-text {
            font-size: 11px;
            text-align: left;
            word-break: break-word;
        }

        .qr-image {
            width: 55px;
            height: 55px;
            margin-left: auto;
        }
    }
</style>



<script>
    document.getElementById("printBtn").addEventListener("click", function() {
        window.print(); // This will activate print preview
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let tds = document.querySelectorAll(".qr-table td");

        tds.forEach(td => {
            td.addEventListener("click", function() {
                this.classList.toggle("selected");
                checkPrintSelection();
            });
        });

        function checkPrintSelection() {
            let selectedTds = document.querySelectorAll(".qr-table td.selected");
            let styleTag = document.getElementById("print-style");

            if (!styleTag) {
                styleTag = document.createElement("style");
                styleTag.id = "print-style";
                document.head.appendChild(styleTag);
            }

            if (selectedTds.length > 0) {
                styleTag.innerHTML = `
                @media print {
                    .qr-table tr {
                        display: none; /* Hide all rows initially */
                    }
                    .qr-table td {
                        visibility: hidden; /* Hide all table data */
                    }
                    .qr-table td.selected {
                        visibility: visible;
                        display: flex;
                    }
                    .qr-table tr:has(td.selected) {
                        display: flex; /* Show only rows that have selected items */
                    }
                    .qr-table tr:has(td.selected) td {
                        display: flex;
                        width: 50%; /* Ensure each cell takes half width for alignment */
                        align-items: center;
                        justify-content: space-between;
                    }
                }
            `;
            } else {
                styleTag.innerHTML = ""; // Print all by default if nothing is selected
            }
        }
    });
</script>