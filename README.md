# 🗂️ Simplified RESTful API for managing inventory across multiple warehouses

This module provides a flexible way to query and filter Stock records along with their related Warehouse and Item models. 
It uses Laravel’s filter scope convention, eager loading, and relationship-based filtering.
Follow simple code structure with applying some separation of concerns(separated logic services classes, using repository pattern, following some solid principles).

---

## 🚀 Features

-- Filter Stock records with custom scopes.
-- Apply filters on related Warehouse and Item models.
-- Eager-load relationships to avoid N+1 query problems.
-- Return a prepared and paginated collection using getTakenPreparedCollection helper.
-- laravel built-in cache & events

---

## 💡 Potential Improvements

-- Role-Based Access Control (RBAC): Introduce fine-grained user permissions (e.g., warehouse manager, stock clerk, admin).
-- Try to let classes interacts with interfaces(Dependency inversion) instead of interacting with the implementation directly.
-- May using new pattern for architecture like HMVC to separate our modules  

---

## 📂 Project Structure (Relevant Parts)
app/
 ├─ Console/
 │   └─Commands/
 │      └─ TruncateTables.php
 |
 ├─ Events/
 │   └─ LowStockDetected.php
 |
 ├─ Helpers/
 │   ├─ Helper.php
 │   └─ Response.php
 |
 ├─ Http/
 │   └─Controllers/
 |         └─Api/
 |             ├─StockController.php
 |             ├─AuthController.php
 |             ├─InventoryController.php
 |             └─WarehouseController.php
 │   └─Requests/
 |             ├─AddToStockRequest.php
 |             ├─LoginRequest.php
 |             ├─RegisterRequest.php
 |             └─StoreTrasferRequest.php
 │   └─Resources/
 |             ├─InventoryItemResource.php
 |             ├─StockResource.php
 |             ├─StockTransferResource.php
 |             └─warehouseResource.php
 |
 ├─ Listeners/
 │   └─ LogLowStockNotification.php
 |
 ├─ Logic/
 │   ├─ StockTransfer.php
 │   ├─ StockManagement.php
 │   └─ InventoryManager.php
 │   └─ UserAuthentication.php
 │
 ├─ Models/
 │   ├─ Stock.php
 │   ├─ Warehouse.php
 │   └─ InventoryItem.php
 │   ├─ User.php
 │   └─ StockTransfer.php
 |
 ├─ Notifications/
 │   └─ NotifyLowStockToAdmin.php
 | 
 ├─ Providers/
 │   └─ EventServiceProvider.php
 |
 ├─ Repositories/
 │   ├─ InventoryRepository.php
 │   ├─ StockRepository.php
 │   └─ TransferRepository.php
 │   ├─ UserRepository.php
 │   └─ WarehouseRepository.php
 |
 ├─ Rules/
 │   └─ StockAvailableRule.php
 |
 ├─ Traits/
 │   ├─ HasFilter.php
 │   └─ HasSort.php
 |
 database/
 ├─ Factories/
 │   ├─ UserFactory.php
 │   ├─ WarehouseFactory.php
 │   └─ InventoryItemFactory.php
 │
 ├─ Seeders/
 │   ├─ UserSeeder.php
 │   ├─ WarehouseSeeder.php
 │   ├─ StockSeeder.php
 │   └─ InventoryItemSeeder.php
 |
 routes/
 ├─ api.php
 |

 ---

## 🛠️ Tech Stack

- Laravel 12
- PHP 8.2+
- MySQL
- Queue: sync
- Mail: aravel log
- Testing: PHPUnit + DB

---

## 📦 Installation

```bash
git clone https://github.com/mohammedawda/inventory_managment.git
cd inventory_managment

# Install dependencies
composer install

# Create environment
cp .env.example .env

# Generate application key
php artisan key:generate

# Set your database credentials in .env
# Run migrations and seeders
# hint: -- if you ran seeder you will have a data for main 3 tables(stock, inventory_item, warehouse) so you can start your application,
#       -- if you want to truncate this data you have a magical artisan command doing truncate on all tables called "app:truncate-tables" or if you want specific table pass --table=<table_name>.
php artisan migrate --seed 

# Start local server
php artisan serve
