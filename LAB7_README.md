# Laboratory Exercise 7: File Upload System

## Quick Start Guide

### Prerequisites
✅ XAMPP running (Apache & MySQL)
✅ Database migrated (`php spark migrate`)
✅ Test users in database (admin, teacher, student)

### Quick Test Commands

```bash
# Navigate to project
cd C:\xampp\htdocs\ITE311-ESYONG

# Run migration (if not done)
php spark migrate

# Start development (XAMPP should be running)
# Access: http://localhost/ITE311-ESYONG
```

---

## Feature Summary

### 🎓 Students Can:
- View materials for enrolled courses
- Download materials securely
- Cannot access materials for non-enrolled courses

### 👨‍🏫 Teachers/Admins Can:
- Upload course materials (PDF, DOC, PPT, etc.)
- Delete materials
- Download materials
- Manage all courses

---

## File Structure

```
app/
├── Controllers/
│   ├── Auth.php (updated)
│   └── Materials.php (NEW)
├── Models/
│   └── MaterialModel.php (NEW)
├── Views/
│   ├── auth/
│   │   └── dashboard.php (updated)
│   └── materials/
│       └── upload.php (NEW)
├── Database/
│   └── Migrations/
│       └── 2025-10-23-175035_CreateMaterialsTable.php (NEW)
└── Config/
    └── Routes.php (updated)

writable/
└── uploads/
    └── materials/ (NEW)
        ├── index.html
        └── .htaccess
```

---

## Routes Added

| Method | Route | Description |
|--------|-------|-------------|
| GET | `/admin/course/:id/upload` | Show upload form |
| POST | `/admin/course/:id/upload` | Handle file upload |
| GET | `/materials/download/:id` | Download material |
| GET | `/materials/delete/:id` | Delete material |

---

## Database Schema

**Table**: `materials`

| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK) | Auto-increment ID |
| course_id | INT (FK) | References courses.id |
| file_name | VARCHAR(255) | Original filename |
| file_path | VARCHAR(255) | Server file path |
| created_at | DATETIME | Upload timestamp |

---

## Testing Checklist

- [ ] Admin can upload files
- [ ] Teacher can upload files
- [ ] Student can download (enrolled only)
- [ ] Student denied (not enrolled)
- [ ] Files appear in dashboard
- [ ] File validation works (type & size)
- [ ] Delete functionality works
- [ ] Direct file access blocked

---

## Screenshots Required

1. ✅ phpMyAdmin - materials table schema
2. ✅ Upload form (admin/teacher view)
3. ✅ Student dashboard with materials
4. ✅ File system (uploads folder)
5. ✅ GitHub repository with commit

---

## Common Issues & Solutions

**Issue**: Upload fails
- Check `writable/uploads/materials/` exists
- Verify folder permissions (755)
- Check PHP `upload_max_filesize` and `post_max_size`

**Issue**: Download blocked
- Verify student is enrolled in course
- Check file exists in uploads folder

**Issue**: Icons not showing
- Check internet connection (Bootstrap Icons from CDN)

---

## Test Accounts

Create these test accounts in your database:

1. **Admin**: admin@lms.com / admin123
2. **Teacher**: teacher@lms.com / teacher123
3. **Student**: student@lms.com / student123

---

## Supported File Types

✅ PDF (.pdf)
✅ Word (.doc, .docx)
✅ PowerPoint (.ppt, .pptx)
✅ Excel (.xls, .xlsx)
✅ Text (.txt)
✅ Archives (.zip, .rar)

**Max Size**: 10 MB

---

## Security Features

✅ File type validation
✅ File size validation
✅ Enrollment verification for downloads
✅ Direct file access prevention (.htaccess)
✅ Role-based access control
✅ CSRF protection

---

## Lab Requirements Met

✅ Step 1: Database migration created and run
✅ Step 2: MaterialModel with required methods
✅ Step 3: Materials controller with upload/delete/download
✅ Step 4: File upload functionality implemented
✅ Step 5: Upload view created with Bootstrap
✅ Step 6: Dashboard displays materials for students
✅ Step 7: Download method with access control
✅ Step 8: Routes configured
✅ Step 9: Ready for testing

---

## Next Steps

1. Test all functionality following `LAB_EXERCISE_7_TESTING_GUIDE.md`
2. Capture required screenshots
3. Commit and push to GitHub
4. Submit screenshots and GitHub link

---

## Support

For detailed testing instructions, see:
📄 `LAB_EXERCISE_7_TESTING_GUIDE.md`

For the lab instructions, refer to your original document.
