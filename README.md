# Laravel Repository Generator

# 
A **Laravel** package designed to streamline the implementation of the **repository pattern** in your projects. This tool generates a complete repository setup, including repository classes, interfaces, and service classes, helping developers maintain clean, organized, and decoupled codebases.
This package is ideal for teams and individuals following **Clean Architecture** and **Domain-Driven Design (DDD)** principles, enabling faster scaffolding of repositories and services for Laravel applications.

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
php artisan make:repository ModelName
```


This will generate the following files automatically:


```bash
app/
├── Repositories
│    └── Interfaces/
│    │   └── ModelNameRepositoryInterface.php
│    └── Repositories/
│       └── ModelNameRepository.php
└── Services/
  └── ModelNameService.php

```


You only need to replace `ModelName` with the relevant name for your feature or entity (e.g., `User`).
## 🌟 Features
- **Automated File Generation**: Instantly creates repository and service structures, saving significant development time.
- **Repository Pattern Support**: Promotes clear separation of concerns between business logic and database operations in Laravel.
- **Configurable Structure**: Adheres to Clean Architecture and Domain-Driven Design principles.
- **PHP 8.1+ Compatibility**: Leverages modern PHP syntax and features for robust development.



## 📂 File Structure Example
If you run the command `php artisan make:repository User`, this is how your file structure will look:
``` plaintext
app/
├── Repositories/
│   ├── Interfaces/
│   │   └── UserRepositoryInterface.php
│   └── Implementations/
│       └── UserRepository.php
└── Services/
    └── UserService.php
```
- **UserRepositoryInterface.php**: Defines the contract for the repository.
- **UserRepository.php**: Implements the repository logic for interacting with the database.
- **UserService.php**: Contains business logic and operations for the `User` entity.



## 🤝 Contributing
Contributions are welcome! If you'd like to contribute to this package, feel free to fork the repository and submit a pull request. Please ensure that your code adheres to PSR standards and includes thorough testing.



## 🧑‍💻 Author
**Amro Boney**
📧 [amroboney@gmail.com](mailto:amroboney@gmail.com)
📍 Riyadh, Saudi Arabia

## 📝 License
This package is open-source software licensed under the [MIT License](LICENSE).
Let me know if you would like further modifications, such as adding badges or additional instructions.



