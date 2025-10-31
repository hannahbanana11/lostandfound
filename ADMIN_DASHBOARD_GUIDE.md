# Lost and Found Management System - Admin Dashboard Documentation

## 🎯 System Overview

The **Lost and Found Management System** is a web-based application built with CodeIgniter 4 that helps manage found items and reunite them with their rightful owners. The system has two main user roles: **Admin** and **User**.

---

## 👥 User Roles

### 1. **Admin**
- Reviews and approves/rejects found item reports
- Manages all items in the system
- Marks items as claimed with claimant details
- Has access to statistics and overview dashboard
- Cannot report items (admin role is for management only)

### 2. **User**
- Can register and log in
- Report found items with details and photos
- View their submitted reports and their status
- View public timeline of approved items
- Cannot approve/reject or manage other users' items

---

## 🔐 Authentication Flow

1. **Registration**: New users can register with username, email, password, and role (user/admin)
2. **Login**: Users log in with email and password
3. **Role-Based Redirect**:
   - Admin → Admin Dashboard
   - User → User Dashboard
4. **Logout**: Destroys session and redirects to login page

---

## 📊 Admin Dashboard Features

### Dashboard Overview
The admin dashboard displays:

#### **Statistics Cards**
- 📊 **Pending Approval**: Number of items waiting for admin review
- ✅ **Approved Items**: Items visible on public timeline
- 👍 **Claimed Items**: Items that have been claimed and returned
- 📦 **Total Items**: All items in the system

#### **Three Main Tabs**

##### 1. **Pending Approval Tab** (Yellow Badge)
- Shows all items with `status = 'pending'`
- Displays full item details:
  - Item name, description, location
  - Photo of the item
  - Founder's name and contact
  - Reporting user's information
  - Date reported
- **Actions**:
  - ✅ **Approve**: Changes status to 'approved', item becomes visible on timeline
  - ❌ **Reject**: Deletes the item from the database

##### 2. **Approved Items Tab** (Green Badge)
- Shows all items with `status = 'approved'`
- These items are visible on the public timeline
- Users can contact the founder to claim items
- **Actions**:
  - 👍 **Mark as Claimed**: Opens claim form to record claimant details

##### 3. **Claimed Items Tab** (Blue Badge)
- Shows all items with `status = 'claimed'`
- Displays complete history:
  - Original item details
  - Claimant name and contact
  - Admin who verified the claim
  - Verification notes
  - Date claimed
- Read-only view for record keeping

---

## 🔄 Item Workflow

### User Side:
```
1. User finds an item
   ↓
2. User reports item via Report Form
   - Fills in: name, contact, item details, location, photo
   ↓
3. Item saved with status = 'pending'
   ↓
4. User sees "Pending Approval" in their dashboard
   ↓
5. Waits for admin approval
```

### Admin Side:
```
1. Admin logs in to dashboard
   ↓
2. Reviews pending items
   ↓
3. Decision:
   - APPROVE → Item appears on timeline
   - REJECT → Item deleted from system
   ↓
4. When owner found:
   - Click "Mark as Claimed"
   - Fill claim form with:
     * Claimant name
     * Claimant contact
     * Verification notes
   ↓
5. Item moves to "Claimed Items"
```

---

## 🗃️ Database Structure

### **Table: `users`**
| Column    | Type         | Description           |
|-----------|--------------|-----------------------|
| id        | INT (PK)     | Auto-increment        |
| username  | VARCHAR(50)  | Unique username       |
| email     | VARCHAR(100) | Unique email          |
| password  | VARCHAR(255) | Hashed password       |
| role      | ENUM         | 'admin' or 'user'     |
| created_at| DATETIME     | Registration date     |

### **Table: `found_items`**
| Column          | Type                                  | Description                    |
|-----------------|---------------------------------------|--------------------------------|
| id              | INT (PK)                              | Auto-increment                 |
| user_id         | INT (FK)                              | User who reported              |
| founder_name    | VARCHAR(100)                          | Name of finder                 |
| contact_number  | VARCHAR(20)                           | Contact number                 |
| item_name       | VARCHAR(100)                          | Item name                      |
| description     | TEXT                                  | Item description               |
| location        | TEXT                                  | Where item was found           |
| image           | VARCHAR(255)                          | Photo filename                 |
| status          | ENUM('pending','approved','claimed')  | Approval status                |
| date_reported   | DATETIME                              | Submission timestamp           |

### **Table: `claimed_items`**
| Column           | Type                                  | Description                    |
|------------------|---------------------------------------|--------------------------------|
| id               | INT (PK)                              | Auto-increment                 |
| item_id          | INT (FK)                              | References found_items.id      |
| claimant_name    | VARCHAR(100)                          | Name of claimant               |
| claimant_contact | VARCHAR(20)                           | Contact number                 |
| verified_by      | INT (FK)                              | Admin user ID                  |
| notes            | TEXT                                  | Verification notes             |
| date_claimed     | DATETIME                              | Claim timestamp                |
| status           | ENUM('pending','approved','declined') | Claim status (all 'approved')  |

---

## 🛣️ Routes Configuration

```php
// Authentication
GET  /auth                  → Login page
GET  /auth/register         → Registration page
POST /auth/login            → Process login
POST /auth/save             → Process registration
GET  /auth/logout           → Logout

// Dashboard (User & Admin)
GET  /dashboard             → Dashboard (role-based view)

// User Actions
GET  /dashboard/report      → Show report form
POST /dashboard/report      → Submit found item

// Admin Actions
GET  /dashboard/approve/:id → Approve item
GET  /dashboard/reject/:id  → Reject item
GET  /dashboard/claim/:id   → Show claim form
POST /dashboard/claim/:id   → Process claim

// Public
GET  /timeline              → View approved items
```

---

## 🎨 UI Features

### Design Elements:
- **Gradient Background**: Purple gradient for modern look
- **Bootstrap 5**: Responsive design
- **Bootstrap Icons**: Visual consistency
- **Card-Based Layout**: Clean organization
- **Color-Coded Status**:
  - 🟡 **Yellow** = Pending
  - 🟢 **Green** = Approved
  - 🔵 **Blue** = Claimed
  - 🔴 **Red** = Reject action

### Interactive Elements:
- Tabbed interface for easy navigation
- Hover effects on cards
- Confirmation dialogs for important actions
- Image upload with preview
- Form validation
- Alert messages for feedback

---

## 🔒 Security Features

1. **CSRF Protection**: All forms use `csrf_field()`
2. **Role-Based Access Control**: Admin routes check user role
3. **Data Sanitization**: Using `esc()` for all outputs
4. **Password Hashing**: Secure password storage
5. **File Upload Validation**:
   - File type checking
   - Size limit (2MB)
   - Random filename generation

---

## 📱 Responsive Design

The system is fully responsive and works on:
- Desktop computers
- Tablets
- Mobile phones

---

## 🚀 Getting Started

### Prerequisites:
- XAMPP or similar local server
- PHP 7.4 or higher
- MySQL database
- CodeIgniter 4

### Installation:
1. Place project in `htdocs` folder
2. Import database schema
3. Configure `app/Config/Database.php`
4. Start Apache and MySQL
5. Access via `http://localhost/LostAndFoundManagement`

### Default Admin Account:
Create an admin account manually in the database or through registration, then change role to 'admin'.

---

## 📖 Usage Guide

### For Users:
1. Register an account
2. Login
3. Click "Report Found Item"
4. Fill in all required information
5. Upload a clear photo
6. Submit and wait for approval
7. Check status in "My Reported Items"

### For Admins:
1. Login with admin account
2. Review pending items in "Pending Approval" tab
3. Approve legitimate reports
4. Reject spam or invalid reports
5. When an owner claims an item:
   - Go to "Approved Items" tab
   - Click "Mark as Claimed"
   - Fill in claimant details
   - Submit to complete the process

---

## ✅ System Benefits

✓ Centralized management of lost and found items
✓ Reduces time to reunite items with owners
✓ Transparent approval process
✓ Complete audit trail of claims
✓ Easy to use interface
✓ Mobile-friendly design
✓ Secure and reliable

---

##  Future Enhancements

Potential features for future versions:
- Email notifications for status changes
- Search functionality in timeline
- Item categories/tags
- Advanced filtering options
- Export reports to PDF
- SMS notifications
- Multi-language support
- Dark mode
- Item expiration (auto-archive old items)

---

## 🐛 Troubleshooting

### Common Issues:

**Issue**: Images not uploading
- **Solution**: Check `uploads/` folder permissions (must be writable)

**Issue**: Can't access admin dashboard
- **Solution**: Verify user role in database is set to 'admin'

**Issue**: Session errors
- **Solution**: Check `writable/session/` folder permissions

**Issue**: Database connection error
- **Solution**: Verify `app/Config/Database.php` settings

---

## 📞 Support

For questions or issues, please contact the development team.

---

**Version**: 1.0  
**Last Updated**: October 31, 2025
