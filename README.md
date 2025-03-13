# 🌐 FameSystems Reseller API SDK

The **FameSystems Reseller API SDK** provides an easy-to-use PHP integration for accessing the [FameSystems](https://famesystems.de) Reseller API.  
With this SDK, resellers can efficiently manage domains, hosting, and other services.

[Swagger](https://docs.resellerapi.de)

[Documentation](https://resellerapi.de)

---

## 📥 Installation

The SDK is available via **Composer** and requires **PHP 8.0 or higher**.

```sh
composer require famesystems/reseller-api-sdk
```

---

## 🛠 Requirements

- PHP **8.0+**
- cURL extension enabled

---

## 🚀 Quick Start

### **1️⃣ Initialize the API Client**

```php
require 'vendor/autoload.php';

use FameSystems\ResellerAPI\Client;
use FameSystems\ResellerAPI\ResellerAPI;

$apiKey = 'YOUR_API_KEY';
$resellerAPI = new ResellerAPI($apiKey);
```

## 📡 API Endpoints

The SDK supports all endpoints provided by the **FameSystems Reseller API**.

📖 **[Full API Documentation](https://docs.resellerapi.de)**

---

## 🔒 Authentication

All requests require a **Bearer Token** for authentication.

```php
$resellerAPI = new ResellerAPI('YOUR_API_KEY');
```

---

## 🛠 Handling Errors

If an error occurs, the SDK returns structured API responses.

---

## 📞 Support

If you need assistance, feel free to contact our **Reseller Support Team**:

📧 **[Contact Support](https://famesystems.de/reselling#reselling-contact)**

🚀 **Start automating your reseller services today with the FameSystems API SDK!**  
