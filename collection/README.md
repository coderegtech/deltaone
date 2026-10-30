# Job Order & Activity Log API – FlexiAPI

This document provides the **data structures**, **API endpoints**, and **example payloads** for managing **Job Orders** and **Activity Logs** via FlexiAPI.  
For more information, refer to the official repository: [FlexiAPI GitHub](https://github.com/gecille87/FlexiAPI/)

---

## 📂 Database Structures

### **1. job_order Table**
| Column         | Type                                          | Description |
|----------------|-----------------------------------------------|-------------|
| `jo_number`    | `VARCHAR(50)` **PK**                         | Unique job order ID |
| `created_by`   | `VARCHAR(100)`                               | Creator's name |
| `requestor`    | `VARCHAR(100)`                               | Requestor's name |
| `created_at`   | `DATETIME`                                   | Manually set date/time |
| `remarks`      | `TEXT`                                       | Job description/details |
| `order_list`   | `JSON`                                       | Array of items with qty & status |
| `activity`     | `VARCHAR(255)`                               | Activity description |
| `approval_stage` | `JSON`                                     | Approval status per role |
| `progress`     | `ENUM('Pending', 'For Release', 'Completed')`| Progress status |
| `extra1`       | `VARCHAR(255)`                               | Optional |
| `extra2`       | `VARCHAR(255)`                               | Optional |
| `extra3`       | `VARCHAR(255)`                               | Optional |

---

### **2. activity_log Table**
| Column         | Type                                          | Description |
|----------------|-----------------------------------------------|-------------|
| `log_id`       | `INT` **PK** AUTO_INCREMENT                   | Unique log entry |
| `log_time`     | `DATETIME DEFAULT CURRENT_TIMESTAMP`          | Timestamp |
| `user_name`    | `VARCHAR(100)`                                | User who performed the action |
| `system_name`  | `VARCHAR(100)`                                | System/module involved |
| `action_type`  | `VARCHAR(100)`                                | Action type (`Create`, `Update`, etc.) |
| `description`  | `TEXT`                                        | Additional details |

---

## 🔌 API Endpoints

Please edit
### **Base URL**
```
{{base_url}} = http://localhost/Your-Folder-Location
```

---

### **1. Job Order Endpoints**
| Method | Endpoint | Description |
|--------|----------|-------------|
| **POST** | `/api/job_order/create/` | Create job order(s) |
| **POST** | `/api/job_order/delete/` | Delete job order(s) |
| **GET**  | `/api/job_order/get/`    | Retrieve job order(s) |
| **POST** | `/api/job_order/update/` | Update job order(s) |

---

### **2. Activity Log Endpoints**
| Method | Endpoint | Description |
|--------|----------|-------------|
| **POST** | `/api/activity_log/create/` | Create activity log |
| **POST** | `/api/activity_log/delete/` | Delete activity log |
| **GET**  | `/api/activity_log/get/`    | Retrieve activity logs |
| **POST** | `/api/activity_log/update/` | Update activity log |

---

## 📌 Example API Payloads

### **1. Create Job Orders**
```json
{
  "table": "job_order",
  "data": [
    {
      "jo_number": "JO-20250814-001",
      "created_by": "Gecille",
      "requestor": "Mark Reyes",
      "created_at": "2025-08-14T08:45:00",
      "remarks": "Urgent request for packaging materials for new product launch.",
      "order_list": [
        { "item": "RL-1001", "qty": 50 },
        { "item": "RL-1002", "qty": 30 },
        { "item": "RL-1003", "qty": 20 }
      ],
      "activity": "",
      "approval_stage": {
        "Department Head": "pending",
        "Logistic": "pending",
        "Plant Manager": "pending"
      },
      "progress": "Pending",
      "extra1": "",
      "extra2": "",
      "extra3": ""
    }
  ]
}
```

---

### **2. Update Job Order**
```json
{
  "table": "job_order",
  "where": {
    "jo_number": "JO-20250814-001"
  },
  "data": {
    "order_list": [
      { "item": "RL-1001", "qty": 12 },
      { "item": "RL-1002", "qty": 11 },
      { "item": "RL-1003", "qty": 10 }
    ],
    "approval_stage": {
      "Department Head": "approved",
      "Logistic": "approved",
      "Plant Manager": "approved"
    }
  }
}
```

---

### **3. Get Job Orders**
```json
{
  "table": "users",
  "condition": { "id": 1 },
  "page": 1,
  "limit": 1
}
```

---

## 📥 Postman Collection
You can import the full Postman collection here:  
[**API Collection Link**](https://github.com/HelloJC24/deltaone/tree/gecille/collection)

---

## 📚 Notes
- `order_list` and `approval_stage` must be valid JSON objects/arrays.
- Ensure `jo_number` is unique when creating a new job order.
- `progress` must be one of: `"Pending"`, `"For Release"`, `"Completed"`.
- Dates must be in `YYYY-MM-DDTHH:mm:ss` format.
