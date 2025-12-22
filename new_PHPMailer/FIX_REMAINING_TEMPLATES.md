# Fix Remaining Hardcoded Templates in admins_email.php

## Summary
There are 5 remaining hardcoded email templates in `admins_email.php` that need to be converted to use `Template.json`:

1. **Line 646**: Interim/Complaint ticket (single ticket)
2. **Line 800**: ISR ticket (single ticket)  
3. **Line 960**: Incident ticket (single ticket)
4. **Line 1145**: Grievance ticket (single ticket)
5. **Line 1345**: Escalation email

## Status
All helper functions have been added to `email_template_helper.php`:
- `buildComplaintTableHtml()` - for interim tickets
- `buildISRTableHtml()` - for ISR tickets
- `buildIncidentTableHtml()` - for incident tickets
- `buildGrievanceTableHtml()` - for grievance tickets

## Next Steps
The code needs to be updated to replace the hardcoded templates with calls to `EmailTemplateHelper::render()` and the table builder functions.

