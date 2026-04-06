# User Management Dashboard - Documentation

## 📊 Overview

Panel admin untuk mengelola akun pengguna dengan fitur lengkap menggunakan tema shadcn/Tailwind yang konsisten dengan desain project Anda.

## ✨ Fitur Utama

### 1. **List User** (`/admin/users`)
- Menampilkan semua users dalam tabel dengan pagination
- Quick access ke edit dan delete
- Multi-select dengan bulk delete
- Status badge untuk role (Admin/User)
- User avatar dengan inisial
- Join date display

**Fitur:**
```
✓ Pagination (15 per page)
✓ Select multiple users
✓ Bulk delete dengan konfirmasi
✓ Edit individual role
✓ Delete individual user
✓ Role indicators (Admin/User)
✓ Total user counter
```

### 2. **Edit User Role** (`/admin/users/{id}/edit`)
- Ubah role user dari admin ke user atau sebaliknya
- Deskripsi role yang jelas
- Warning alert saat remove admin role
- User information display (ID, status, join date)

**Form:**
```
- Radio button untuk pilih role
- Admin role: Full system access
- User role: Standard access
- Warning untuk role admin
```

### 3. **Delete User**
- Single delete dengan confirmation
- Bulk delete dengan confirmation
- Success/error messages

## 🎨 Design System

**Colors:**
- Primary: `#FF6B00` (Orange)
- Admin Badge: Purple/Purple-900
- User Badge: Blue/Blue-900
- Danger Action: Red
- Success Message: Green

**Components:**
- Status badges dengan warna role
- Role indicator tags
- Icon buttons (edit, delete)
- Bulk action bar
- Confirmation dialogs
- Dark/Light mode support

## 📁 File Structure

```
app/
└── Http/Controllers/Admin/
    └── UserController.php          # Logic untuk user management

resources/views/
└── admin/
    └── users/
        ├── index.blade.php         # List semua users
        └── edit.blade.php          # Form edit role

routes/
└── web.php                         # Routes untuk user management
```

## 🔌 Routes

```php
// List users
GET /admin/users                    → admin.users.index

// Edit user role form
GET /admin/users/{user}/edit        → admin.users.edit

// Update user role
POST /admin/users/{user}/role       → admin.users.update-role

// Delete single user
DELETE /admin/users/{user}          → admin.users.destroy

// Bulk delete users
POST /admin/users/bulk-delete       → admin.users.bulk-delete
```

## 🛠️ Controller Methods

### `UserController`

```php
public function index()
// Get paginated user list

public function edit(User $user)
// Show edit role form

public function updateRole(Request $request, User $user)
// Update user role

public function destroy(User $user)
// Delete single user

public function bulkDelete(Request $request)
// Delete multiple users
```

## 💾 Database

**User Table Columns:**
```
- id
- name
- email
- role (default: 'user')
- password
- created_at
- updated_at
```

**Role Values:**
- `admin` - Administrator access
- `user` - Regular user access

## 🎯 User Experience

### List Page Features
```
Header
├── Title + Info
├── Total Users Counter
└── Bulk Delete Actions (when selected)

Table
├── Checkbox (select)
├── User Avatar + Name
├── Email
├── Role Badge
├── Join Date
├── Actions (Edit/Delete)
└── Pagination

Styling
├── Hover effects
├── Dark mode support
├── Responsive layout
└── Icon indicators
```

### Edit Page Features
```
User Card
├── Avatar (initials, gradient)
├── Name
├── Email
├── Join Date
└── Status Badge

Role Selection
├── Admin option with description
├── User option with description
└── Warning alert (if removing admin)

User Info
├── User ID display
├── Status display
└── Timestamps (if needed)

Actions
├── Save button
└── Cancel button
```

## 🔒 Security Features

1. **Route Protection**: Admin middleware required
2. **CSRF Protection**: @csrf in forms
3. **Authorization**: Only admins can access
4. **Confirmation Dialog**: Before delete
5. **Input Validation**: Role validation

## 🚀 How to Use

### View All Users
1. Navigate to sidebar → "Users"
2. or directly go to `/admin/users`

### Change User Role
1. Click the **Edit** icon (pencil) next to user
2. Select new role (Admin or User)
3. Click "Save Changes"

### Delete User
1. Click **Delete** icon (trash) next to user
2. Confirm deletion in dialog
3. User will be deleted after confirmation

### Bulk Delete Users
1. Check multiple user checkboxes
2. Bulk delete bar appears
3. Click "Delete Selected"
4. Confirm to delete all selected users

## 📝 Notes

- Role migration already applied
- User model fillable includes 'role'
- Sidebar updated with Users link
- Responsive design (works on mobile)
- Follows project theme (dark/light mode)
- Material Icons used for consistency
- Tailwind CSS with shadcn styling

## 🐛 Troubleshooting

**Routes not showing:**
```bash
php artisan route:list | grep admin.users
```

**User not deleting:**
- Check if user is cascade protected in other tables
- Verify user isn't current logged-in admin

**Role not updating:**
- Verify role column in users table
- Check request validation

---

Created: April 5, 2026
Last Updated: April 5, 2026
