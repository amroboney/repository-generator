# Laravel Repository Generator

A simple Laravel package that helps you generate a complete repository pattern setup including:

- Repository class
- Interface
- Service class

This package is ideal for developers who follow a clean architecture or domain-driven design (DDD) and want to quickly scaffold their services and repositories.

---

## 📦 Installation

You can install the package via Composer:

```bash
composer require amroboney/repository-generator
```

If the package is not on Packagist and hosted on GitHub, add this to your Laravel app’s composer.json:


```bash
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/amroboney/repository-generator"
  }
]
```

Then install it with:

```bash
composer require amroboney/repository-generator:dev-main
```


## ⚙️ Usage
Generate a repository, interface, and service using the artisan command:


```bash
php artisan make:repository User
```


This will generate the following files automatically:


```bash
app/
├── Repositories
│    └── Interfaces/
│    │   └── UserRepositoryInterface.php
│    ├── Repositories/
│       └── UserRepository.php
└── Services/
  └── UserService.php

```

## 🧑‍💻 Author
Amro Boney
amroboney@gmail.com
Riyadh, Suadi Arabia



