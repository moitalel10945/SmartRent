# 🏠 SmartRent

**SmartRent** is a modern rental management system designed to help landlords manage properties, tenants, and rent payments efficiently — with support for mobile payments like M-Pesa.

---

## 🚀 Overview

Managing rental properties manually can be stressful and error-prone. SmartRent simplifies the process by providing a centralized system where landlords can:

- Manage properties and tenants  
- Assign tenancies  
- Track rent payments  
- Monitor arrears  
- Generate reports  

---

## ✨ Features

### 🔐 Authentication
- User registration & login  
- Secure authentication using Laravel  

### 🏢 Property Management
- Add, edit, and delete properties  
- Organize multiple rental units  

### 👥 Tenant Management
- Landlords can create and manage tenants  
- Each tenant belongs to a specific landlord  

### 📄 Tenancy Assignment
- Assign tenants to properties  
- Define rent amount and start date  

### 💰 Payment Tracking
- Record rent payments  
- Monitor payment history  

### ⚠️ Arrears Management
- Automatically track unpaid rent  
- Identify overdue tenants  

### 📊 Reports
- View financial summaries  
- Track income and payment trends  

---

## 🧠 System Design

### Roles

| Role      | Description |
|----------|------------|
| Admin    | System owner (restricted access) |
| Landlord | Main user who manages properties and tenants |
| Tenant   | Created by landlords (not self-registered) |

---

### Key Relationships

- A **landlord** owns many **tenants**
- A **tenant** has a **tenancy**
- A **tenancy** belongs to a **property**
- Payments are linked to **tenancies**

---

## 🛠️ Tech Stack

- **Backend:** Laravel  
- **Frontend:** Blade + Tailwind CSS  
- **Database:** MySQL  
- **Authentication:** Laravel Breeze  
- **Build Tool:** Vite  

---

## 📸 Screenshots

> Add screenshots here:

- Homepage  
- Dashboard  
- Properties page  
- Payments page  

---

## ⚙️ Installation

### 1. Clone the repository

```bash
git clone https://github.com/your-username/smartrent.git
cd smartrent