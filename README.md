# 🧹 aws-eraser

![screenshot-1](./screenshots/main.png)
![screenshot-2](./screenshots/dashboard.png)

A web-based tool that helps users securely **wipe AWS resources** with support for dry-run, actual deletion, and resource logs.  
Built for multi-user environments with individual key management, execution history, and simple interface.

---

## ✨ Features

- ✅ User registration & login (with security code)
- 🔐 Encrypted storage of AWS access & secret keys
- 🌍 Region selection via dropdown (e.g., `ap-northeast-2`, `us-east-1`)
- 🧪 Dry-run support (see what will be deleted)
- 💣 Execute real deletion with confirmation
- 📦 Run status tracking (`in progress`, `done`, etc.)
- 📜 Execution logs view
- 🗃️ Manage & delete previously used access keys

---

## 🛠️ Tech Stack

| Category        | Stack                     |
|-----------------|---------------------------|
| Language        | PHP 8.2                   |
| Frontend        | HTML5 + Bootstrap 5       |
| Backend         | PHP-FPM + MySQL           |
| Infra           | Docker, Nginx             |
| AWS Integration | aws-nuke CLI              |
| Domain & SSL    | ZeroSSL + `aws-eraser.kro.kr` |
| Hosting         | Ubuntu 22.04 (GCP VM)     |
| Version Control | Git + GitHub              |

---

## 📁 Screenshots

Make sure the following image files exist in your repo:
