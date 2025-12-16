<?php
// Secret code
$secretCode = "18";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputCode = $_POST['secret_code'] ?? '';
    if ($inputCode === $secretCode) {
        // Set session to indicate successful login
        $_SESSION['authenticated'] = true;
    } else {
        echo "<p style='color: red;'>Incorrect secret code. Please try again.</p>";
    }
}

// Check if the user is authenticated
if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    // Display the secret code input form
    ?>
    <form method="post" action="">
        <label for="secret_code">Enter Secret Code:</label>
        <input type="password" name="secret_code" id="secret_code" required>
        <button type="submit">Submit</button>
    </form>
    <?php
    exit; // Stop further script execution
}

// Content to display after successful authentication
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dev Page</title>
</head>
<body>
    <h1>Welcome to Dev Page</h1>
   
<?php
echo '<p><h2><b>Change Logs</b></h2></p>';

echo '<p>
<li>Version: DEC23</li>
<li>Release date  : 16-12-23</li>
<li>Start date : 04-12-23</li>
</p>';

include 'env.php';

echo 'Domain:   ' . $config_set['DOMAIN'];
echo '<br>';
echo 'Current DB   :  ' . $config_set['DBNAME'];
echo '<br>';



echo '<p>
<h4>OVERVIEW</h4>
<li>Support for 7 modules:<b> ADF, IPDF, OPF, PC, ISR, SG, INCI</b></li>
<li>Consolidated report for all modules.</li>
<li>Response trend analysis chart in all feedback report page.</li>
<li>Feedback source tracking. (src?=)</li>
<li>Raw downloads added for all ticketing pages.</li>
<li>Adding departments and questions in between the feedback form.</li>
<li>Excel importer.</li>
<li>Updated mobile filter.</li>
<li>Security updated.</li>
</p>';

echo '
<p>
<h4>ALERTING CHANGES</h4>
<li>New SMS and New email structure added.</li>
<li>SMS with tracking links for admin, department head and patient.</li>
<li>Reasons in email alerts.</li>
<li>SMS and email when user is created.</li>
<li>SMS and email when employee is added to send OTP</li>
<li>SMS and email to department head when reopen and transfer a ticket</li>
<li>SMS and Email alert feature and UI to admin for selected/accessed modules only.</li>
<li>Stats page added.</li>
</p>';


echo '
<p>
<h4>UI CHANGES</h4>
<li>Overall summary supporting all 7 modules.</li>
<li>Settings and User page</li>
<li>Display content changed in PSAT, NPS, Total feeddbacks pages. (Controlling with Helper)</li>
<li>Display content changed in Ticket tracking pages. (Controlling with Helper)</li>
<li>Conslidated report showing to admin also.</li>
<li>Card UI for PCF, ISR forms.</li>
<li>Verification page added before submission of feedback in SR,SG,IN.</li>
<li>Wording changes.</li>
<li>Tooltip changes.</li>
</p>';


echo '
<p>
<h4>LOGIC CHANGES</h4>
<li>Patients with NPS below 6 are categorised as unsatisfied patients.</li>
<li>Primary consultant drop-down in IP/OP form.</li>
<li>Demography selection for selected language in all input forms.</li>
<li>Floor/Ward storing in ticket tables.</li>
<li>Transfer of ticket reworked</li>
<li>Attachment of Image in form</li>
</p>';


echo '<p>
1.	General comment issues in all login
2.	Develop ADF report
3.	Brought separate report for all ticket pages in all modules 
4.	Service request/incident/grievance and description issues in individual page for employee module
5.	Feedback is submitted with out selecting reason/parameter 
6.	Transfer issues/ transfer ticket is not reflected on department login
7.	Count issues upon transfer the ticket.
8.	Concern is not displayed on all ticket pages upon taking action on transfer ticket
9.	Ticketing download for all 3-employee module (ISR, Incident and Grievance)
10.	Top notification content/word changes for employee module
11.	Word correction in IP/OP/PCF module
12.	Issues while delete any user 
13.	Few feedback is not submitted in dashboard due to bed number charset set to 10 in database.
14.	Updating PIN issues in employee list
15.	NPS, PSAT and feedback response chart issues 
16.	Fix Consolidated report  
17.	Create separate page for ticket resolution rate and average resolution time
18.	Helper logic is implemented across all pages 
19.	Count issues in admit patient and admitted patient list
20.	Add an option/popup to discharge the patient without sending an SMS
21.	Resend and regenerate PIN for employee module input form
22.	Customized and word changes in all module report 
23.	Added priority, incident type, patient details in incident report.

</p>';
?>
</body>
</html>

