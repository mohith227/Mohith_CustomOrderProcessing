# Mohith_CustomOrderProcessing

## Overview
Mohith_CustomOrderProcessing is a custom Magento 2 module that enhances order processing by providing:
- A REST API for updating order statuses.
- An event observer that logs order status changes.
- An admin UI component (grid and form) to manage logged order status changes.
- Email notifications for shipped orders.

---

## Installation Instructions

### 1️⃣ Upload the Module
Upload the module to your Magento installation under:
```
app/code/Mohith/CustomOrderProcessing
```

### 2️⃣ Enable the Module
Run the following commands:
```sh
php bin/magento module:enable Vendor_CustomOrderProcessing
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:flush
```

### 3️⃣ Verify Module Installation
Check if the module is enabled:
```sh
php bin/magento module:status | grep Vendor_CustomOrderProcessing
```
It should return `Vendor_CustomOrderProcessing: Enabled`.

---

## API Usage

### Endpoint:
```sh
POST /rest/V2/order/update-status
```

### Authentication:
Use a Bearer token for authentication.

### Sample Request:
```sh
curl -X POST "https://yourmagento.com/rest/V1/order/update-status" \
     -H "Content-Type: application/json" \
     -H "Authorization: Bearer your_access_token" \
     -d '{
           "incrementId": "000000001",
           "status": "processing"
         }'
```

### Sample Response:
```json
{
    "message": "Order status updated successfully."
}
```
---

### Sample postman Request:
```json
{
           "incrementId": "000000002",
           "status": "processing"
}
```

### Sample Postman Response:
```json
{
    "message": "Order status updated successfully."
}
```

### Sample postman Request for order not found:
```json
{
           "incrementId": "000000028",
           "status": "processing"
}
```

### Sample Postman Response:
```json
{
    "message": "Order not found.",
    "trace": null
}
```
---

## Admin Panel UI

The module includes an admin grid to view order status logs.

### Navigation:
1. Go to **Admin Panel**
2. Navigate to **Sales > Custom Order Processing**
3. View order status changes and manage entries.

---

## Event Observer: Order Status Change

### Implementation Details
The module implements an event observer that listens to `sales_order_save_after` to track order status changes.

### Logging Order Status Changes
- When an order status is updated, the observer logs the change into a custom database table `custom_order_status_log`.
- The table records:
  - Order ID
  - Old Status
  - New Status
  - Timestamp

### Sending Email Notifications
- If an order status is changed to `shipped`, an email notification is triggered and sent to the customer.

---

## Admin Panel UI

The module includes an admin grid to view order status logs. 

### Navigation:
1. Go to **Admin Panel**
2. Navigate to **Sales > Order Status Logs**
3. View order status changes and manage entries.

---

## Architectural Decisions

### ✅ **Magento 2 Best Practices**
- Uses **PSR-4 autoloading** and Magento’s dependency injection system.
- Avoids **direct ObjectManager usage**.
- Implements **service contracts** (RepositoryInterface) for data management.

### ✅ **Performance Considerations**
- Uses **event observers** (`sales_order_save_after`) instead of frequent database queries.
- Implements **repository patterns** instead of direct SQL queries.
- Optimized indexing to prevent unnecessary Magento performance overhead.

### ✅ **Security Measures**
- Implements **Magento API authentication** using Bearer tokens.
- Validates **order existence and allowed status transitions** before updating.
- Prevents unauthorized database modifications via proper ACL permissions.

---

## Troubleshooting

### 1️⃣ API Returns `"Class \"string\" does not exist"`
**Solution:** Remove scalar type hints (`string`) from the service interface:
```php
public function updateStatus($incrementId, $status);
```

### 2️⃣ API Returns `"Order not found."`
**Solution:** Ensure you are using a valid order increment ID (`000000001`).

### 3️⃣ Module Not Showing in Admin
**Solution:** Run:
```sh
php bin/magento setup:upgrade
php bin/magento setup:di:co
php bin/magento indexer:reindex
php bin/magento cache:flush
```

---

## Contribution & Support
Feel free to contribute or report issues. Contact support at `mohithnanjundamurthy05@gmail.com`.

---

© 2025 Mohith_CustomOrderProcessing. All rights reserved.
