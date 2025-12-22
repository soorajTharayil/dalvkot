# Template Review Summary

## ✅ Completed - Now Using Templates

1. **Patient Emails** (`patient_email.php`)
   - ✅ Welcome email
   - ✅ Discharge email

2. **Admin Welcome Emails** (`admins_email.php`)
   - ✅ Welcome email for role 2
   - ✅ Welcome email for role 3
   - ✅ IP ticket single (just updated)
   - ✅ IP ticket multiple (just updated)

3. **Department Head Welcome Emails** (`department_head_email.php`)
   - ✅ Welcome email for role 4
   - ✅ Welcome email for role 8
   - ✅ Welcome email for role 10
   - ✅ Appreciation email

## ⚠️ Still Hardcoded - Need Template Conversion

### In `admins_email.php`:
1. **OP Ticket Emails** (lines ~490-550)
   - `admin.op_ticket_single` template exists but not used
   - `admin.op_ticket_multiple` template exists but not used

2. **Interim/Complaint Ticket Emails** (lines ~580-700)
   - `admin.interim_ticket` template exists but not used

3. **ISR Ticket Emails** (lines ~720-850)
   - `admin.isr_ticket` template exists but not used

4. **Incident Ticket Emails** (lines ~880-1030)
   - `admin.incident_ticket` template exists but not used
   - Has complex table structure

5. **Grievance Ticket Emails** (lines ~1060-1180)
   - `admin.grievance_ticket` template exists but not used

6. **Escalation Emails** (lines ~1300-1370)
   - `admin.escalation_level1` template exists but not used
   - `admin.escalation_level2` template exists but not used

### In `department_head_email.php`:
1. **IP Ticket Emails** (lines ~200-280)
   - `department_head.ip_ticket` template exists but not used

2. **OP Ticket Emails** (lines ~320-380)
   - `department_head.op_ticket` template exists but not used

3. **Interim Ticket Emails** (lines ~440-520)
   - `department_head.interim_ticket` template exists but not used

4. **ISR Ticket Emails** (lines ~580-670)
   - `department_head.isr_ticket` template exists but not used

5. **Incident Ticket Emails** (lines ~740-850)
   - `department_head.incident_ticket` template exists but not used

6. **Grievance Ticket Emails** (lines ~920-1020)
   - `department_head.grievance_ticket` template exists but not used

### In `test_mail.php`:
- Similar structure to `admins_email.php` - all ticket emails still hardcoded

### In `tat_due_date.php`:
- `tat_due_date.incident_assigned` template exists but not used
- Has complex table structure with reminder text

## 🔧 Helper Functions Available

The `EmailTemplateHelper` class now has:
- ✅ `buildReasonsHtml()` - Builds reasons HTML from array
- ✅ `buildCommentsHtml()` - Builds comments HTML from array  
- ✅ `buildGeneralCommentHtml()` - Builds general comment with UTF-8 encoding
- ✅ `escapeHtml()` - Escapes HTML special characters
- ✅ `render()` - Renders templates with variables
- ✅ `insertNotification()` - Inserts with proper UTF-8 encoding

## 📝 Pattern to Follow

For each hardcoded email, follow this pattern:

```php
// OLD WAY (hardcoded):
$message1 = 'Dear Team, <br /><br />';
$message1 .= 'We would like to bring to your attention...';
// ... more string concatenation

// NEW WAY (using template):
$reasonsHtml = EmailTemplateHelper::buildReasonsHtml($param->reason, $res);
$commentsHtml = EmailTemplateHelper::buildCommentsHtml($param->comment);
$generalCommentHtml = EmailTemplateHelper::buildGeneralCommentHtml($param->suggestionText ?? '');

$emailData = EmailTemplateHelper::render('admin.op_ticket_single', [
    'hospitalname' => $hospitalname,
    'ticket_id' => $department_object->id,
    'patient_name' => EmailTemplateHelper::escapeHtml($param->name),
    // ... other variables
    'reasons' => $reasonsHtml,
    'comments' => $commentsHtml,
    'general_comment' => $generalCommentHtml,
    'link' => $link
]);

$message1 = $emailData['body'];
$Subject = $emailData['subject'];
```

## 🎯 Next Steps

1. Convert OP ticket emails in `admins_email.php`
2. Convert Interim ticket emails in `admins_email.php`
3. Convert ISR ticket emails in `admins_email.php`
4. Convert Incident ticket emails (may need table builder helper)
5. Convert Grievance ticket emails
6. Convert Escalation emails
7. Convert all department_head ticket emails
8. Convert `test_mail.php` emails
9. Convert `tat_due_date.php` email

All templates are already defined in `Template.json` - just need to update the code to use them!

