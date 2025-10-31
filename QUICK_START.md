# 🎯 QUICK START GUIDE - Admin Dashboard

## 🔑 Login Credentials

### Admin Account:
- **Email:** `hannahcamillecunanan@gmail.com`
- **Password:** (your admin password)

### Test User Accounts:
- **User 1:** `cunananhannahcamille@gmail.com`
- **User 2:** `jerwinagustin032@gmail.com`
- **User 3:** `angiemallari@gmail.com`

---

## 🚀 Quick Test Steps

### 1️⃣ Test as USER (5 minutes)
```
1. Login with user account
2. Click "Report Found Item"
3. Fill form:
   - Your name: "Test User"
   - Contact: "09123456789"
   - Item: "Black Wallet"
   - Description: "Leather wallet with ID cards inside"
   - Location: "Library 3rd Floor"
   - Upload any image
4. Submit
5. See "Pending Approval" status
6. Logout
```

### 2️⃣ Test as ADMIN (5 minutes)
```
1. Login with admin account
2. See statistics cards with counts
3. Go to "Pending Reports" tab
4. See the item you just reported
5. Click "Approve"
6. Item moves to "Approved Items" tab
7. Go to "Approved Items" tab
8. Click "Mark as Claimed"
9. Fill claim form:
   - Claimant: "John Doe"
   - Contact: "09987654321"
   - Notes: "Verified with ID"
10. Submit
11. Item moves to "Claimed Items" tab
12. Done! ✅
```

### 3️⃣ Check Timeline (2 minutes)
```
1. Click "Timeline" in navbar
2. See approved items (before claiming)
3. Verify item details are visible
4. Test complete! ✅
```

---

## 📊 Admin Dashboard Sections

| Tab               | Shows                           | Actions              |
|-------------------|---------------------------------|----------------------|
| Pending Reports   | status='pending'                | Approve / Reject     |
| Approved Items    | status='approved'               | Mark as Claimed      |
| Claimed Items     | status='claimed'                | View only (archive)  |

---

## 🎨 Visual Guide

### Statistics Cards (Top Row):
```
┌──────────┬──────────┬──────────┬──────────┐
│ PENDING  │ APPROVED │ CLAIMED  │  TOTAL   │
│    🟡    │    🟢    │    🔵    │    ⬛    │
│    #     │    #     │    #     │    #     │
└──────────┴──────────┴──────────┴──────────┘
```

### Item Card Layout:
```
┌──────────────────────────────────────────────┐
│  [IMAGE]  Item Name                          │
│           Description: ...                   │
│           📍 Location: ...                   │
│           👤 Found by: ...                   │
│           ☎️  Contact: ...                   │
│           📅 Date: ...                       │
│                                              │
│           [STATUS BADGE]                     │
│           [ACTION BUTTONS]                   │
└──────────────────────────────────────────────┘
```

---

## 🔗 Important URLs

```
Login:          /auth
Register:       /auth/register
Admin Dashboard: /dashboard (auto-redirect for admin)
User Dashboard:  /dashboard (auto-redirect for user)
Report Item:    /dashboard/report
Timeline:       /timeline
Logout:         /auth/logout
```

---

## ⚡ Quick Actions

### Approve an Item:
```
/dashboard/approve/{id}
```

### Reject an Item:
```
/dashboard/reject/{id}
```

### Claim an Item:
```
/dashboard/claim/{id}
```

---

## 🎯 Success Indicators

✅ Login → See correct dashboard for role
✅ User reports item → Shows "Pending Approval"
✅ Admin approves → Item on timeline
✅ Admin claims → Item in archive with details
✅ Statistics cards update automatically
✅ Alert messages show for each action

---

## 📱 Testing Checklist

### Admin Functions:
- [ ] View statistics
- [ ] See pending items
- [ ] Approve item
- [ ] Reject item
- [ ] See approved items
- [ ] Mark as claimed
- [ ] Fill claim form
- [ ] View claimed archive

### User Functions:
- [ ] Register account
- [ ] Login
- [ ] Report found item
- [ ] Upload image
- [ ] View my items
- [ ] Check item status

### Public Features:
- [ ] View timeline
- [ ] See approved items only
- [ ] View contact information

---

## 🐛 Common Issues & Fixes

| Issue                    | Fix                                |
|--------------------------|------------------------------------|
| Can't login              | Check email/password               |
| Images not showing       | Check uploads/ folder exists       |
| No pending items         | Report item as user first          |
| Buttons not working      | Check browser console for errors   |
| Session expired          | Login again                        |

---

## 💡 Pro Tips

1. **Open in 2 browsers:** One for admin, one for user
2. **Test workflow:** User reports → Admin approves → Check timeline
3. **Check statistics:** Numbers update after each action
4. **Use sample data:** Create multiple test items
5. **Test edge cases:** Empty states, no images, long descriptions

---

## 📞 Need Help?

1. Check `ADMIN_DASHBOARD_GUIDE.md` for detailed info
2. Check `IMPLEMENTATION_SUMMARY.md` for technical details
3. Review `ADMIN_DASHBOARD_FIXED.md` for what was fixed

---

**System Ready! Start Testing! 🚀**
