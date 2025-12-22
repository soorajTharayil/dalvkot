# Email Template System Refactoring

## Overview
This refactoring addresses two main issues:
1. **Encoding Issue**: Non-ASCII characters (like Hindi) were being incorrectly inserted into notifications
2. **Template Management**: All email templates were hardcoded in PHP files, making them difficult to manage

## Changes Made

### 1. Created `Template.json`
- Centralized all email templates in a single JSON file
- Easy to update and maintain
- Organized by category (patient, admin, department_head, tat_due_date)

### 2. Created `email_template_helper.php`
- **EmailTemplateHelper class** with functions to:
  - Load templates from JSON
  - Render templates with variables
  - Handle UTF-8 encoding properly
  - Safely escape strings for database insertion
  - Build HTML for comments and general comments with proper encoding

### 3. Updated Files

#### `patient_email.php`
- Now uses templates from `Template.json`
- Proper UTF-8 encoding for database connections
- Uses `EmailTemplateHelper::insertNotification()` for safe insertion

#### `test_mail.php`
- Fixed encoding issue for "General Comment" field
- Uses `EmailTemplateHelper::buildGeneralCommentHtml()` to properly handle non-ASCII characters
- All INSERT queries now use the helper function for proper encoding

## Key Features

### UTF-8 Encoding Fix
The main issue was that non-ASCII characters (like Hindi text in `suggestionText`) were not being properly encoded. The solution:

1. **Database Connection**: Sets charset to `utf8mb4` for both connections
2. **String Encoding**: Ensures all strings are UTF-8 before processing
3. **HTML Escaping**: Uses `htmlspecialchars()` with UTF-8 encoding for user input
4. **Database Insertion**: Uses `EmailTemplateHelper::insertNotification()` which:
   - Ensures UTF-8 encoding
   - Sets database charset
   - Properly escapes strings

### Template System
- **Easy Updates**: All email content is in `Template.json`
- **Variable Replacement**: Uses `{{variable}}` syntax
- **Type Safety**: Validates template paths and provides error messages

## Usage Examples

### Using Templates
```php
// Load template helper
include('email_template_helper.php');

// Render a template
$emailData = EmailTemplateHelper::render('patient.welcome', [
    'name' => $name,
    'hospitalname' => $hospitalname,
    'interim_link' => $interim_link
]);

// Insert with proper encoding
EmailTemplateHelper::insertNotification(
    $conn_g,
    'email',
    $emailData['body'],
    $email,
    $emailData['subject'],
    $HID
);
```

### Handling General Comments (Fixes Encoding Issue)
```php
// Old way (had encoding issues):
$message1 .= '<br /><strong>General Comment:</strong>' . $param_ip->suggestionText . ' <br />';

// New way (properly handles UTF-8):
$generalCommentHtml = EmailTemplateHelper::buildGeneralCommentHtml($param_ip->suggestionText ?? '');
$message1 .= $generalCommentHtml;
```

## Best Practices Applied

1. **Separation of Concerns**: Templates separated from business logic
2. **DRY Principle**: No code duplication for template rendering
3. **UTF-8 Support**: Proper handling of all character encodings
4. **Security**: Proper escaping of user input
5. **Maintainability**: Easy to update email content without touching PHP code
6. **Error Handling**: Template loading includes error checking

## Database Configuration

Ensure your database tables use UTF-8 encoding:
```sql
ALTER TABLE notification CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## Testing

After implementing these changes:
1. Test with Hindi/non-ASCII characters in `suggestionText`
2. Verify emails display correctly
3. Check database records for proper encoding
4. Test all email types (patient, admin, department_head)

## Next Steps (Optional Improvements)

1. **Update `admins_email.php`**: Convert to use templates (partially done)
2. **Update `department_head_email.php`**: Convert to use templates
3. **Update `tat_due_date.php`**: Convert to use templates
4. **Add Template Validation**: Validate template structure on load
5. **Add Template Caching**: Cache loaded templates for performance

## Notes

- The `Template.json` file should be kept in sync with any email content changes
- Always use `EmailTemplateHelper::insertNotification()` instead of direct INSERT queries
- For user input that may contain HTML, use `EmailTemplateHelper::escapeHtml()`
- The helper automatically ensures UTF-8 encoding for all database operations

